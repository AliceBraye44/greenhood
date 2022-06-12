module.exports = {
    purge: [],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
        theme: {
            colors: {
                green: '#257e3e',
            }
        },
        variants: {
            extend: {
                backgroundColor: ['odd', 'even'],
                textColor: ['active'],
            },
        },
        plugins: [],
    }
}