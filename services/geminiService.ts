
import { GoogleGenAI, Type, FunctionDeclaration } from "@google/genai";
import { Language } from "../types";

// Always use process.env.API_KEY directly in the GoogleGenAI instance.

const markAttendanceFn: FunctionDeclaration = {
  name: 'mark_attendance',
  parameters: {
    type: Type.OBJECT,
    description: 'Marks a student as present or absent in the database.',
    properties: {
      student_name: { type: Type.STRING, description: 'The name of the student' },
      status: { type: Type.STRING, description: 'Present or Absent' },
      reason: { type: Type.STRING, description: 'Optional reason for absence' },
    },
    required: ['student_name', 'status'],
  },
};

const checkFeesFn: FunctionDeclaration = {
  name: 'check_fees',
  parameters: {
    type: Type.OBJECT,
    description: 'Retrieves fee information for a specific student.',
    properties: {
      student_name: { type: Type.STRING, description: 'The name of the student' },
    },
    required: ['student_name'],
  },
};

export const orchestrateAI = async (message: string, audioData?: string) => {
  const ai = new GoogleGenAI({ apiKey: process.env.API_KEY });
  
  const systemInstruction = `
    You are an AI School Administrator for the "AI-SOS" platform, a WhatsApp-first system for schools in Afghanistan/Iran.
    Users (teachers/parents) send messages in Pashto, Persian, or English.
    
    Current School Context:
    - Standard Students: Ahmed Khan, Sara Jan, Mustafa Omar, Maryam Gohar.
    - Class: Grade 4.
    
    CRITICAL:
    1. First, identify the language of the input (Pashto, Persian, or English). If it is "Pinglish" or "Romanized Pashto", identify it as such but treat the underlying language as the primary.
    2. Transcribe/Translate: If input is Pashto/Persian, translate to English for internal logic.
    3. Intent Extraction: Determine if they want to mark attendance, check fees, or ask a general policy question.
    4. Tool Calling: Use 'mark_attendance' or 'check_fees' when appropriate.
    5. Response: Always confirm actions clearly. If multiple students match a name, ask for clarification.
    
    Response Format:
    Your text response should be preceded by a line saying "LANGUAGE: [Language Name]" and "CONFIDENCE: [0.0-1.0]". 
    Example: 
    LANGUAGE: Pashto
    CONFIDENCE: 0.98
    [Your actual response here]
  `;

  try {
    const response = await ai.models.generateContent({
      model: 'gemini-3-flash-preview',
      contents: audioData ? {
        parts: [
          { inlineData: { mimeType: 'audio/wav', data: audioData } },
          { text: message || "Analyze this audio, identify the language, and respond appropriately." }
        ]
      } : { parts: [{ text: message }] },
      config: {
        systemInstruction,
        tools: [{ functionDeclarations: [markAttendanceFn, checkFeesFn] }],
      },
    });

    const fullText = response.text || "";
    const langMatch = fullText.match(/LANGUAGE:\s*([^\n\r]*)/i);
    const confMatch = fullText.match(/CONFIDENCE:\s*([^\n\r]*)/i);
    
    const detectedLanguage = langMatch ? langMatch[1].trim() : "Unknown";
    const confidence = confMatch ? confMatch[1].trim() : "0.0";
    
    // Remove the metadata lines from the final text displayed to user
    const cleanedText = fullText.replace(/LANGUAGE:.*\n?/i, '').replace(/CONFIDENCE:.*\n?/i, '').trim();

    return {
      text: cleanedText,
      detectedLanguage,
      confidence,
      functionCalls: response.functionCalls,
      grounding: response.candidates?.[0]?.groundingMetadata?.groundingChunks
    };
  } catch (error) {
    console.error("Gemini AI Error:", error);
    throw error;
  }
};
