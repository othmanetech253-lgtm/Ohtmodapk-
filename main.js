fetch('apps.json')
.then(response => response.text())
.then(text => {
    const lines = text.trim().split('\n');
    const appList = document.getElementById('appList');

    lines.forEach(line => {
        if (!line) return;
        const app = JSON.parse(line);

        const card = document.createElement('div');
        card.className = 'app-card';
        card.innerHTML = `
            <img src="${app.icon}" alt="${app.name}">
            <h3>${app.name}</h3>
            <p>${app.desc}</p>
            <a href="${app.apk}" download>تحميل</a>
        `;
        appList.appendChild(card);
    });
});