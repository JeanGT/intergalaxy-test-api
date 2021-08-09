<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo Prestador</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        h1 {
            font-size: 28px;
            text-align: center;
        }

        p {
            font-size: 15px;
            text-align: justify;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .box {
            border: 1px solid black;
            width: 100px;
            margin-left: auto;
            padding: 10px
        }

        .half-width {
            width: 50%;
        }

    </style>
</head>

<body>
    <h1>Recibo de Prestação de Serviço</h1>

    <div><b>{{$is_duplicate ? 2 : 1}}ª Via</b></div>

    <div class="text-right box">Nº: {{ $id }}</div>

    <p>
        Recebi(emos) de <b>{{ $employer_name }}</b> - CPF nº <b>{{ $employer_cpf }}</b>, a importância de
        <b>R${{ $money_amount }}</b> referente ao mes <b>{{ $month }}</b>.

        <br />

        Para maior clareza firmo(amos) o presente recibo para que produza os seus efeitos, dando plena, rasa e
        irrevogável quitação, pelo valor recebido.
    </p>
    <hr class="half-width">
    <div class="text-center">
        {{ $employee_name }} <br />
        CPF: {{ $employee_cpf }}
    </div>

</body>

</html>
