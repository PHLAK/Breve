import { defineConfig } from 'vitepress'

const head = [
    ['link', { rel: 'icon', href: '/images/breve.svg' }],
];

if (process.env.ENVIRONMENT === 'production') {
    head.push(['script', { defer: '', src: 'https://analytics.phlak.net/script.js', 'data-website-id': '07fa46f2-8a0d-4cc0-b3aa-c7bf9e1b6be7' }]);
}

export default defineConfig({
    title: 'Breve Documentation',
    description: 'The official Breve documentation',

    head: head,

    themeConfig: {
        logo: '/images/breve.svg',

        nav: [
            { text: 'Help & Support', link: 'https://github.com/PHLAK/Breve/discussions' },
            { text: 'Changelog', link: 'https://github.com/PHLAK/Breve/releases' },
        ],

        sidebar: [
            {
                items: [
                    { text: 'Introduction', link: '/' },
                    { text: 'Installation', link: '/installation' },
                    { text: 'Getting Started', link: '/getting-started' },
                ]
            },
            {
                text: 'Configuration',
                items: [
                    { text: 'Configuration Overview', link: '/configuration/configuration-overview' },
                    { text: 'Environment Variables', link: '/configuration/environment-variables' },
                    { text: 'Advanced Configuration', link: '/configuration/advanced-configuration' },
                ]
            },
            {
                text: 'Publishing',
                items: [
                    { text: 'Posts', link: '/publishing/posts' },
                    { text: 'Pages', link: '/publishing/pages' },
                    { text: 'Markdown', link: '/publishing/markdown' },
                ]
            },
            {
                text: 'Customization',
                items: [
                    { text: 'Custom Themes', link: '/customization/custom-themes' },
                ]
            },
            {
                text: 'Help & Support',
                items: [
                    { text: 'Troubleshooting', link: '/help-and-support/troubleshooting' },
                ]
            },
        ],

        outline: { level: [2, 4] },

        search: { provider: 'local' },

        socialLinks: [
            { icon: 'bluesky', link: 'https://bsky.app/profile/breve.blog' },
            { icon: 'github', link: 'https://github.com/PHLAK/Breve' },
        ],

        editLink: {
            pattern: 'https://github.com/PHLAK/Breve/edit/master/docs/:path'
        },

        lastUpdated: true,
    },
});
