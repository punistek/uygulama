<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IoTV - Mobil IPTV</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #121212;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100vh;
    }
    header {
      background-color: #1f1f1f;
      width: 100%;
      padding: 15px;
      text-align: center;
      font-size: 1.5em;
      font-weight: bold;
      color: #00bcd4;
    }
    video {
      width: 100%;
      height: 30vh;
      background-color: black;
    }
    #category-list, #channel-list {
      width: 100%;
      padding: 10px;
      overflow-x: auto;
      display: flex;
      gap: 10px;
    }
    .category-item, .channel-item {
      background-color: #2c2c2c;
      padding: 10px;
      border-radius: 10px;
      white-space: nowrap;
      cursor: pointer;
      flex-shrink: 0;
      transition: background-color 0.3s;
    }
    .category-item:hover, .channel-item:hover {
      background-color: #3a3a3a;
    }
    .channel-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      min-width: 200px;
    }
    #search-container {
      width: 100%;
      padding: 10px;
      display: flex;
      gap: 10px;
      background-color: #1f1f1f;
    }
    #search-input {
      flex: 1;
      padding: 10px;
      border-radius: 5px;
      border: none;
    }
    button {
      background-color: #00bcd4;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
    }
    #modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #2c2c2c;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
    }
    .modal-content button {
      margin-top: 10px;
      width: 100%;
    }
  </style>
</head>
<body>
  <header>IoTV</header>
  <video id="video-player" controls></video>
  <div id="search-container">
    <input type="text" id="search-input" placeholder="Kanal ara...">
    <button id="clear-btn">Temizle</button>
  </div>
  <div id="category-list"></div>
  <div id="channel-list"></div>

  <div id="modal">
    <div class="modal-content">
      <p id="modal-title"></p>
      <button class="play-btn">Oynat</button>
      <button class="copy-btn">Kopyala</button>
      <button class="cancel-btn">İptal</button>
    </div>
  </div>

  <script>
    const proxyUrl = 'https://api.codetabs.com/v1/proxy/?quest=';
    const mainUrl = 'https://vavoo.to/channels';
    const player = document.getElementById('video-player');
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-btn');
    let selectedChannelUrl = '';
    let categories = {};
    let allChannels = [];
    const baseUrl = 'https://vavoo.to/play/';

    document.querySelector('.cancel-btn').onclick = () => modal.style.display = 'none';
    document.querySelector('.play-btn').onclick = () => {
      player.src = selectedChannelUrl;
      player.play();
      modal.style.display = 'none';
    };
    document.querySelector('.copy-btn').onclick = () => {
      navigator.clipboard.writeText(selectedChannelUrl);
      modal.style.display = 'none';
    };

    searchInput.addEventListener('input', () => {
      const q = searchInput.value.toLowerCase();
      const filtered = allChannels.filter(c => c.name.toLowerCase().includes(q));
      populateChannelList(filtered);
    });

    clearBtn.onclick = () => {
      searchInput.value = '';
      populateChannelList(allChannels);
    };

    async function loadChannels() {
      try {
        const response = await fetch(proxyUrl + mainUrl);
        const data = await response.json();
        categories = {};
        allChannels = [];

        data.forEach(({ country, id, name }) => {
          const url = baseUrl + id + '/index.m3u8';
          const channel = { id, name, url };
          allChannels.push(channel);
          if (!categories[country]) categories[country] = [];
          categories[country].push(channel);
        });

        populateCategoryList();
        populateChannelList(allChannels);
      } catch (e) {
        alert('Kanal listesi alınamadı.');
        console.error(e);
      }
    }

    function populateCategoryList() {
      const container = document.getElementById('category-list');
      container.innerHTML = '';
      Object.keys(categories).forEach(cat => {
        const div = document.createElement('div');
        div.className = 'category-item';
        div.textContent = cat;
        div.onclick = () => populateChannelList(categories[cat]);
        container.appendChild(div);
      });
    }

    function populateChannelList(list) {
      const container = document.getElementById('channel-list');
      container.innerHTML = '';
      list.forEach(channel => {
        const div = document.createElement('div');
        div.className = 'channel-item';
        div.innerHTML = `<span>${channel.name}</span>`;
        div.onclick = () => {
          selectedChannelUrl = channel.url;
          modalTitle.textContent = channel.name;
          modal.style.display = 'flex';
        };
        container.appendChild(div);
      });
    }

    loadChannels();
  </script>
</body>
</html>
