<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout publication</title>
</head>

<body>

    <form action="save_publications" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="user_name">Identifiant</label></td>
                <td><input type="text" name="user_name" id="user_name"></td>
            </tr>

            <tr>
                <td><label for="publications">Fichier</label></td>
                <td><input type="file" name="publications" id="publications"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Ajouter"></td>
            </tr>
        </table>
    </form>


</body>

</html>