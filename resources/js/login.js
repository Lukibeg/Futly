import './bootstrap';

// Função para mostrar o texto na página de boas vindas.
function showContainerText() {
    const container = document.querySelector('.page-info');
    const value = 'Bem vindo a sua plataforma de futebol!'
    const containerLength = container.textContent.length;
    const textLength = value.length;
    let text = '';
    let count = 0;

    for (let i = 0; i < textLength; i++) {
        setTimeout(() => {
            text += value[i];
            container.textContent = text;
        }, 100 * i);
    }
}

showContainerText();