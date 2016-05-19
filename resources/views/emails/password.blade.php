<body style="text-align: center;">
    <table border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto">
        <tr>
            <td style="text-align: center;">
                <img src="{{ asset('assets/admin/img/logo.png') }}" alt="{{ config("app.name") }}" />
            </td>
        </tr>
        <tr>
            <td>
                Clique aqui para cadastrar sua nova senha: <a href="{{ route("admin::cadastrar-senha",[ "token" => $token ]) }}">Resetar senha</a><br/>
                Essa solicitação expira em 1 hora.
            </td>
        </tr>
    </table>
</body>