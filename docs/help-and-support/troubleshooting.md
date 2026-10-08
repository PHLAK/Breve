# Troubleshooting

## Common Issues

### I added a post but it doesn't appear on the site

You must run `breve publish:posts` after creating the file to render and cache
the post. Also verify the post does not have `draft: true` set in its front
matter.

### Images aren't loading

Confirm the image file is in `data/files` and referenced with a leading slash
(e.g., `/files/image.png`). Paths are case-sensitive.

### My environment variable changes aren't taking effect

After editing your environment variables, your container must be restarted for
the changes to take effect.

### Search returns no results

Try running `breve reindex` to rebuild the search index. If the problem
persists, check that your posts contain text content in their body.

## Frequently Asked Questions

### How do I back up my Breve site?

Back up the `data` directory. Because Breve uses a flat-file structure, all
your content, uploads and custom themes are stored there.

### How do I update Breve?

Pull the latest Docker image and restart your containers. If you have made
manual changes to application files, make sure you back them up before updating.

### What's the difference between a post and a page?

Posts are dated entries that appear on the home page and support tags, authors,
and pagination. Pages are static, appear in the navigation menu, and do not
support tags or dates.

### Can I use HTML in my posts and pages?

Yes. Breve supports raw HTML alongside Markdown in your content. Note that
`<script>` tags are stripped from rendered content for security reasons.

### How do I unpublish or delete a post?

Delete the `.md` file from `data/posts` and run `breve publish:posts` to render 
the posts and update the site cache.

## Still Stuck?

Please report bugs to the [GitHub Issue Tracker](https://github.com/PHLAK/Breve/issues).

For general help and support, join our [GitHub Discussions](https://github.com/PHLAK/Breve/discussions)
or reach out on [Bluesky](https://bsky.app/profile/breve.blog).
