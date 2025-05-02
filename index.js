const express = require("express");
const fetch = require("node-fetch");
const app = express();

// Telegram bot bilgilerin
const TOKEN = "7426497726:AAEPDzRSsXjAvTFpN_B7bteQj00a6wacSAg";
const CHAT_ID = "1224314188";
const SECRET_KEY = "123456"; // Android uygulamanla paylaşacağın gizli anahtar

app.get("/", async (req, res) => {
  const msg = req.query.msg;
  const key = req.query.key;

  if (key !== SECRET_KEY) return res.status(403).send("ACCESS DENIED");
  if (!msg) return res.status(400).send("NO MESSAGE");

  const url = `https://api.telegram.org/bot${TOKEN}/sendMessage?chat_id=${CHAT_ID}&text=${encodeURIComponent(msg)}`;

  try {
    const tgRes = await fetch(url);
    const data = await tgRes.json();
    res.json(data);
  } catch (e) {
    res.status(500).send("ERROR");
  }
});

app.listen(process.env.PORT || 3000, () => {
  console.log("Server running...");
});

