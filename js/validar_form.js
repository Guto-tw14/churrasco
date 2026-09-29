document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#form-cadastro-participante");
    if (!form) {
        return;
    }

    const nome = form.elements.nome;
    const turma = form.elements.turma;
    const tipo = form.elements.tipo;

    function validarCampo(campo, mensagem) {
        campo.setCustomValidity(mensagem);
    }

    function validarNome() {
        const valor = nome.value.trim();
        validarCampo(nome, valor.length >= 3 ? "" : "Informe um nome com pelo menos 3 caracteres.");
    }

    function validarTurma() {
        validarCampo(turma, turma.value.trim() ? "" : "Informe a turma.");
    }

    function validarTipo() {
        validarCampo(tipo, tipo.value ? "" : "Selecione o tipo de churrasco.");
    }

    nome.addEventListener("input", validarNome);
    turma.addEventListener("input", validarTurma);
    tipo.addEventListener("change", validarTipo);

    form.addEventListener("submit", function (event) {
        validarNome();
        validarTurma();
        validarTipo();

        if (!form.checkValidity()) {
            event.preventDefault();
            form.reportValidity();
        }
    });
});