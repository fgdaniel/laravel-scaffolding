<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('dashboard::includes.head')
	</head>
	<body>
		{{ $slot }}
		@include('dashboard::includes.foot')
	</body>
</html>
