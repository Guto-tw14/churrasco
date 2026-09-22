function confirmarExclusao(event) {
    const confirmacao = confirm("Deseja realmente excluir esta inscrição?");
    if (!confirmacao) {
        event.preventDefault();
        return false;
    }
    return true;
}