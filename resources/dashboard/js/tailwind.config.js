module.exports = {
	mode: 'JIT',
    purge: [
		'./resources/dashboard/**/*{.blade.php, .vue, .js}',
		'./resources/dashboard/*{.blade.php, .vue, .js}',
	],
    darkMode: false, // or 'media' or 'class'
    theme: {
		extend: {},
    },
    variants: {
		extend: {},
    },
    plugins: [],
}
