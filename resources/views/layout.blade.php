<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
		<script src="https://use.fontawesome.com/dce32b2015.js"></script>
		@yield('head')
{{--			<style>
				html, body {
					height: 100%;
				}

				body {
					margin: 0;
					padding: 0;
					width: 100%;
					display: table;
					font-weight: 100;
					font-family: 'Lato';
				}

				.container {
					text-align: center;
					display: table-cell;
					vertical-align: middle;
				}

				.content {
					text-align: center;
					display: inline-block;
				}

				.title {
					font-size: 96px;
				}
			</style>--}}
    </head>
    <body>
	@yield('dashboard')
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					@yield('body')

					@yield('footer')
				</div>
			</div>
		</div>
	@yield('end')
    </body>
</html>
