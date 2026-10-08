# Pages

```text{3}
/path/to/breve
├── data
│   ├── pages
│   │   ├── about-this-blog.md
│   │   └── something-else.md
│   └── [other data]
└── docker-compose.yaml
```

## Front Matter

Pages, like posts, _must_ contain some metadata such as a title. This metadata
is defined as "front matter", that is, some YAML set between
triple-dashes (i.e. `---`) and must be the first thing in the file.

::: code-group
```markdown [about-this-blog.md]
---
title: About this Blog
link: About
weight: 200
---

Your page content goes here...
```
:::

### Metadata Fields

The following metadata fields are supported for pages.

| Key      | Type     | Required | Details                                          |
| -------- | -------- | :------: | ------------------------------------------------ |
| `title`  | `string` |    ✅️    | Page title                                       |
| `link`   | `string` |    ❌️    | Navigation link text                             |
| `weight` | `int`    |    ❌️    | Lower values will be sorted before higher values |

> [!TIP]
> Metadata fields that are not required may be omitted.

## Markdown

Immediately following the front matter should be your page contents, authored in
Markdown format. See the [Markdown documentation](markdown.md) for more
information about authoring with Markdown.

## Publishing Pages

> [!IMPORTANT]
> After adding a page you must publish your pages in order for the new page to 
> show up in the list of pages (i.e. navigation).

Publishing pages will render the contents of and update the cache for all pages.

::: code-group
```console [Docker]
docker compose run --rm breve publish:pages
```

```console [Manual]
php breve publish:pages
```
:::

### Updating a Page

Sometimes you may need to update a page after it's already been published (e.g.
after making some edits). Publishing a single page will render the contents and
update the cache for a single page specified by it's slug.

::: code-group
```console [Docker]
docker compose run --rm breve publish:page <slug>
```

```console [Manual]
php breve publish:page <slug>
```
:::
