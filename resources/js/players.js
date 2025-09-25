// Função para mostrar o texto na página de jogadores.
function showContainerText() {
    const container = document.querySelector('.description-text');
    const value = 'Aqui você pode visualizar todos os jogadores presentes na plataforma'
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