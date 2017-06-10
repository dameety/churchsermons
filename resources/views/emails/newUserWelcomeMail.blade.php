<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Welcome Mail</title>
	    <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">

	</head>
	<body>

		<div class="card">
            <div class="card-header">
            </div>
				<h4> {{ $mailHeading }} {{ $user->name }}</h4>
            <div class="card-block">

				<p> {{ $mailBody }} </p>
    
            </div>
        </div>

	</body>
</html>