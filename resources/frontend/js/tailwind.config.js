module.exports = {
	mode: 'JIT',
    purge: [
		'./resources/frontend/**/*{.blade.php, .vue, .js}',
		'./resources/frontend/*{.blade.php, .vue, .js}',
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
