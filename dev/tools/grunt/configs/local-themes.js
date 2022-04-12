/**
 * Magento/luma - en_US
 * grunt exec:luma && grunt less:luma
 * grunt exec:luma && grunt less:luma && grunt watch
 *
 * Yaroslav/luma - uk_UA
 * grunt exec:yaroslav_luma_uk_ua && grunt less:yaroslav_luma_uk_ua
 * grunt exec:yaroslav_luma_uk_ua && grunt less:yaroslav_luma_uk_ua && grunt watch:yaroslav_luma_uk_ua
 */
module.exports = {
    luma: {
        area: 'frontend',
        name: 'Magento/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
    yaroslav_luma_uk_ua: {
        area: 'frontend',
        name: 'Yaroslav/luma',
        locale: 'uk_UA',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    }
};
