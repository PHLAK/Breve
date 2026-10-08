# Getting Started

This guide will walk you through creating, publishing, and viewing your first
blog post. It assumes you already have Breve installed and running. If you
haven't installed Breve yet, see the [Installation guide](installation.md).

## Creating Your First Post

Posts live in the `data/posts` directory as Markdown files. Create a new file
named `hello-world.md` in that directory.

```text{4}
/path/to/breve
├── data
│   └── posts
│       └── hello-world.md
└── docker-compose.yaml
```

> [!IMPORTANT]
> The name of the file (not including the `.md` extension) becomes the post
> "slug", which shows up in the URL. For example, `hello-world.md` will be
> accessible at `example.com/post/hello-world`.

Open `hello-world.md` in your favorite text editor and add some content.

::: code-group
```markdown [hello-world.md]
---
title: Hello, World!
published: 2025-05-27 12:00:00
author: Your Name
---

Welcome to Breve! This is your first post.

You can write in **Markdown**, which makes formatting easy. For example:

- Create lists
- Add [links](https://example.com)
- Or emphasize *text*

Happy publishing!
```
:::

### Publishing Your Post

After saving your post, you must publish it so Breve can render the Markdown
and update the site cache.

::: code-group
```console [Docker]
docker compose run --rm breve publish:posts
```

```console [Manual]
php breve publish:posts
```
:::

You should see output indicating that your post has been published successfully.

> [!TIP]
> You will need to run `publish:posts` every time you add, edit, or delete a
> post for the changes to appear on the site.

### View It Live

Open your browser and navigate to the URL where Breve is running. Your new post
will appear on the home page. Click the post title to read the full article.

## Next Steps

Now that you've published your first post, you can explore more of what Breve
has to offer:

- Learn about [post options](publishing/posts.md) such as excerpts, featured
  images, tags and drafts
- Create [static pages](publishing/pages.md) like an About or Contact page
- [Configure your site](configuration/configuration-overview.md) with a custom
  title, customize the navigation or layout and more
