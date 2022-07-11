<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <style>
        table {
            text-align: center;
            width: 100%;
            border: 1px solid black;
        }

        th {
            border: 1px solid black;
        }

        td {
            border: 1px solid black;

        }

    </style>
    <div class="title" role="alert" style="text-align: center;">
        {{ $data['title'] }}
    </div>
    <div class="title" role="alert" style="text-align: center">
        {{ $data['date'] }}
    </div>


    <table>
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Stock</th>
                <th scope="col">Category</th>
                <th scope="col">Expired_at</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr id="prod{{ $product['id'] }}">
                    <td>{{ $product['id'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['stock'] }}</td>
                    <td>{{ $product['category_name'] }}</td>
                    <td>{{ $product['expired_at'] }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
