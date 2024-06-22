<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Formulário de Serviços</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#formulario-servicos').submit(function (event) {
                event.preventDefault(); // Evita o comportamento padrão de submit do formulário

                $.ajax({
                    type: 'POST',
                    url: 'teste1.php', // Caminho do arquivo PHP que processa o formulário
                    data: $(this).serialize(), // Serializa os dados do formulário para enviar
                    success: function (response) {
                        console.log(response); // Log da resposta para depuração
                        const jsonResponse = JSON.parse(response);
                        $('#resultado').html(jsonResponse.html_resposta); // Exibe a resposta do servidor na div com id "resultado"

                        // Guarda os dados para futuro uso
                        $('#mao_de_obra_valor').val(jsonResponse.mao_de_obra);
                        $('#total_servicos_valor').val(jsonResponse.total_servicos);
                        $('#total_valor').val(jsonResponse.total);

                        // Guarda os serviços
                        jsonResponse.servicos.forEach((servico, index) => {
                            $('#servico_descricao_' + index).val(servico.descricao);
                            $('#servico_valor_' + index).val(servico.valor);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error: " + error);
                        console.error("Status: " + status);
                        console.error(xhr.responseText);
                        $('#resultado').html('<p>Erro ao enviar os dados. Por favor, tente novamente.</p>');
                    }
                });
            });
        });
    </script>
</head>

<body>
    <h2>Formulário de Serviços Realizados</h2>
    <form id="formulario-servicos" method="post" action="">
        <fieldset>
            <legend>Valor da Mão de Obra</legend>
            <label for="mao_de_obra">Valor:</label>
            <input type="number" name="mao_de_obra" value="0" required><br>
        </fieldset>

        <fieldset>
            <legend>Valores dos Serviços Realizados</legend>
            <label for="servicos[0][descricao]">Serviço 1:</label>
            <input type="text" name="servicos[0][descricao]" required>
            <label for="servicos[0][valor]">Valor:</label>
            <input type="number" name="servicos[0][valor]" value="0" required><br>

            <label for="servicos[1][descricao]">Serviço 2:</label>
            <input type="text" name="servicos[1][descricao]">
            <label for="servicos[1][valor]">Valor:</label>
            <input type="number" name="servicos[1][valor]" value="0"><br>

            <label for="servicos[2][descricao]">Serviço 3:</label>
            <input type="text" name="servicos[2][descricao]">
            <label for="servicos[2][valor]">Valor:</label>
            <input type="number" name="servicos[2][valor]" value="0"><br>

            <label for="servicos[3][descricao]">Serviço 4:</label>
            <input type="text" name="servicos[3][descricao]">
            <label for="servicos[3][valor]">Valor:</label>
            <input type="number" name="servicos[3][valor]" value="0"><br>

            <label for="servicos[4][descricao]">Serviço 5:</label>
            <input type="text" name="servicos[4][descricao]">
            <label for="servicos[4][valor]">Valor:</label>
            <input type="number" name="servicos[4][valor]" value="0"><br>

            <label for="servicos[5][descricao]">Serviço 6:</label>
            <input type="text" name="servicos[5][descricao]">
            <label for="servicos[5][valor]">Valor:</label>
            <input type="number" name="servicos[5][valor]" value="0"><br>
        </fieldset>
        <input type="submit" value="Enviar">
    </form>

    <div id="resultado"></div> <!-- Aqui será exibida a resposta do servidor -->

    <!-- Hidden inputs to store the processed values -->
    <input type="hidden" id="mao_de_obra_valor" name="mao_de_obra_valor">
    <input type="hidden" id="total_servicos_valor" name="total_servicos_valor">
    <input type="hidden" id="total_valor" name="total_valor">

    <!-- Hidden inputs to store the service details -->
    <input type="text" id="servico_descricao_0" name="servico_descricao_0">
    <input type="text" id="servico_valor_0" name="servico_valor_0">
    <input type="hidden" id="servico_descricao_1" name="servico_descricao_1">
    <input type="hidden" id="servico_valor_1" name="servico_valor_1">
    <input type="hidden" id="servico_descricao_2" name="servico_descricao_2">
    <input type="hidden" id="servico_valor_2" name="servico_valor_2">
    <input type="hidden" id="servico_descricao_3" name="servico_descricao_3">
    <input type="hidden" id="servico_valor_3" name="servico_valor_3">
    <input type="hidden" id="servico_descricao_4" name="servico_descricao_4">
    <input type="hidden" id="servico_valor_4" name="servico_valor_4">
    <input type="hidden" id="servico_descricao_5" name="servico_descricao_5">
    <input type="hidden" id="servico_valor_5" name="servico_valor_5">

</body>

</html>
