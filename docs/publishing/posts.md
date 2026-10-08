# Posts

As a publishing platform (i.e. blog), the main purpose of Breve is to facilitate
the authoring and publishing of posts. This is made possible through Markdown
files with a bit of YAML sprinkled in. To get started you may add your files
with an extension of `.md` in the `data/posts` directory.

```text{3}
/path/to/breve
├── data
│   ├── posts
│   │   ├── some-amazing-post.md
│   │   └── yet-another-post.md
│   └── [other data]
└── docker-compose.yaml
```

> [!TIP]
> The name of the file (not including the `.md` extension) will be used as the
> post "slug", the part that shows up in the URL. For example, for the file 
> `data/posts/vogon-poetry.md` the URL would be something like
> `example.com/post/vogon-poetry`.

## Front Matter

In order for a post to be recognized by Breve it _must_ contain some metadata
like a title and published date. This metadata is defined as "front matter",
that is, some YAML set between triple-dashes (i.e. `---`) and must be the first
thing in the file.

::: code-group
```markdown [vogon-poetry.md]
---
title: An analysis of Vogon poetry
published: 2021-02-06 08:56:42
author: Arthur Dent
image:
  url: https://example.com/image.png
  caption: Photo by [Tricia McMillan](https://example.com)
tags: [Vogons, Poetry, Art]
draft: true
---

Your post content goes here...
```
:::

### Metadata Fields

The following metadata fields are supported.

| Key              | Type            | Required  | Details                                              |
| ---------------- | --------------- | :-------: | ---------------------------------------------------- |
|  `title`         | `string`        |     ✅️    | Post title                                           |
|  `published`     | `string`, `int` |     ✅️    | Post publish date as datetime string or timestamp    |
|  `author`        | `string`        |     ❌️    | Post author                                          |
|  `image.url`     | `string`        |     ❌️    | Reference uploaded images as `/files/image-name.png` |
|  `image.caption` | `string`        |     ❌️    | Markdown allowed                                     |
|  `tags`          | `array`         |     ❌️    | Array of tags                                        |
|  `draft`         | `boolean`       |     ❌️    |                                                      |
|  `canonical`     | `string`        |     ❌️    | Canonical URL for the post                           |

> [!TIP]
> Metadata fields that are not required may be omitted.

## Markdown

Immediately following the front matter should be your post contents, authored in
Markdown format. See the [Markdown documentation](markdown.md) for more
information about authoring with Markdown.

## Excerpts

By default, the main posts list will show the entire contents of a post. If
instead you would like to only show an _excerpt_ of the post you may specify
the content to show by wrapping it with `<!-- excerpt -->` and `<!-- /excerpt -->`
tags. The portion of text within the excerpt tags will be the content that 
is displayed in the main posts list.

```markdown
<!-- excerpt -->
The answer to life, the universe and everything is ...
<!-- /excerpt -->

Why that would be 42 of course!
```

## Publishing Posts

> [!IMPORTANT]
> After adding a post you must publish your posts in order for the new post to 
> show up in the list of posts.

Publishing posts will render the contents of and update the cache for all posts.

::: code-group
```console [Docker]
docker compose run --rm breve publish:posts
```

```console [Manual]
php breve publish:posts
```
:::

### Updating a Post

Sometimes you may need to update a post after it's already been published (e.g.
after making some edits). Publishing a single post will render the contents and
update the cache for a single post specified by it's slug.

::: code-group
```console [Docker]
docker compose run --rm breve publish:post <slug>
```

```console [Manual]
php breve publish:post <slug>
```
:::
