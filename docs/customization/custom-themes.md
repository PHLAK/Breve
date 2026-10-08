# Custom Themes

> [!DANGER]
> Custom themes are a _work-in-progress_ and not finalized. Things may change
> and/or break with updates _without warning_.  If there's something you would
> like to see changed about custom themes, open a feature request.

## Using a Custom Theme

Add your theme to the `themes` directory.

```text{3}
/path/to/breve
├── themes
│   └── [custom themes will go here]
└── docker-compose.yaml
```

Enable your theme by setting the `THEME` environment variable to the name of the
theme (i.e. the folder name) you would like to use.

::: code-group
```dotenv [.env]
# SITE_TITLE="Yet another amazing blog"
# META_DESCRIPTION="Yet another amazing blog, published with Breve."

THEME=hyperspace #[!code focus]

# PAGINATION=true
# POSTS_PER_PAGE=10
```
:::

## Custom Theme Development

A theme is a folder that consists of the views, icons, styles and scripts needed
to render the theme. These files are nested in separate, top-level folders within
the theme directory.

```text{5-8}
/path/to/breve
├── data
├── themes
│   └── some-theme
│       ├── css
│       ├── icons
│       ├── js
│       └── views
└── docker-compose.yaml
```

### Views

```text{9}
/path/to/breve
├── data
├── themes
│   └── some-theme
│       ├── css
│       ├── icons
│       ├── js
│       └── views
│           └── [Theme view files go here]
└── docker-compose.yaml
```

Every theme is composed of several view files that each handle a specific page
of the application. To create a theme you must create each of the following
files. The purpose of and data available to each page is documented below.

#### `authors.twig` <badge type="info" text="/authors" />

Displays the list of authors and a count of their posts.

##### Data

- `authors`: An alphabetically sorted list of authors where the key is the author's name and
  the value is the number of published articles by that author.

  ```php
  [
      'Arthur Dent' => 42,
      'Ford Prefect' => 13,
      'Tricia McMillan' => 27,
  ]
  ```

#### `error.twig`

Shows an error message when an error occurs. For example, shows a "Page not
found" error for `404` errors.

##### Data

- `message`: A message of the error that occurred.

#### `feed.twig` <badge type="info" text="/feed" />

Renders the RSS feed of published posts.

##### Data

- `title`: The site title
- `description`: The site meta description
- `posts`: A list of [`Post`](https://github.com/PHLAK/Breve/blob/master/app/Data/Post.php)
  objects with the same properties as those listed for `posts.twig` below

#### `page.twig` <badge type="info" text="/page/{slug}" />

Displays a user-generated page.

##### Data

- `page`: A [`Page`](https://github.com/PHLAK/Breve/blob/master/app/Data/Page.php)
  object with the following properties
  - `title`: The page title
  - `link`: The link text
  - `body`: The rendered page contents (HTML)
  - `weight`: The sort weight

#### `posts.twig` <badge type="info" text="/" /> <badge type="info" text="/author/{author}" /> <badge type="info" text="/tag/{tag}" />

Displays a paginated list of posts. Used for the home page, posts by a specific
author, and posts with a specific tag.

##### Data

- `posts`: A list of [`Post`](https://github.com/PHLAK/Breve/blob/master/app/Data/Post.php)
  objects for the current page.
  - `Post`: An individual [`Post`](https://github.com/PHLAK/Breve/blob/master/app/Data/Post.php)
    object with following properties
    - `title`: The post title
    - `body`: The rendered post contents (HTML)
    - `published`: The post publish date (a Carbon date object)
    - `author`: The post author
    - `tags`: A list of post tags
    - `image`: A [`PostImage`](https://github.com/PHLAK/Breve/blob/master/app/Data/PostImage.php)
      object with the following properties
        - `url`: The post image URL
        - `caption`: The raw post image caption (Markdown)
    - `canonical`: The canonical post link
    - `draft`: Post draft status
    - `excerpt`: The post excerpt (rendered HTML, from the `excerpt()` method)

- `paginator`: A [`Paginator`](https://github.com/PHLAK/Breve/blob/master/app/Utilities/Paginator.php)
  object with the following properties
  - `pages`: Total number of pages
  - `previous`: The previous page number (or `null` if on the first page)
  - `next`: The next page number (or `null` if on the last page)

#### `post.twig` <badge type="info" text="/post/{slug}" />

Displays a single blog post.

##### Data

- `post`: A [`Post`](https://github.com/PHLAK/Breve/blob/master/app/Data/Post.php)
  object with the following properties
  - `title`: The post title
  - `body`: The rendered post contents (HTML)
  - `published`: The post publish date (a Carbon date object)
  - `author`: The author's name
  - `tags`: A list of tags
  - `image`: A [`PostImage`](https://github.com/PHLAK/Breve/blob/master/app/Data/PostImage.php)
    object with the following properties
    - `url`: The post image URL
    - `caption`: The raw post image caption (Markdown)
  - `canonical`: A canonical URL
  - `draft`: Whether the post is a draft
  - `excerpt`: The post excerpt (rendered HTML, from the `excerpt()` method)

#### `tags.twig` <badge type="info" text="/tags" />

Displays a list of all tags and a count of posts for each.

##### Data

- `tags`: An alphabetically sorted list of tags where the key is the tag name
  and the value is the number of posts with that tag.

  ```php
  [
      'adventure' => 5,
      'coding' => 12,
      'php' => 8,
      'tutorial' => 3,
  ]
  ```

### Icons

```text{7}
/path/to/breve
├── data
├── themes
│   └── some-theme
│       ├── css
│       ├── icons
│       │   └── [Theme icon files go here]
│       ├── js
│       └── views
└── docker-compose.yaml
```

`/path/to/breve/themes/{theme}/icons`

### Styles

```text{6}
/path/to/breve
├── data
├── themes
│   └── some-theme
│       ├── css
│       │   └──[Theme stylesheets go here]
│       ├── icons
│       ├── js
│       └── views
└── docker-compose.yaml
```

`/path/to/breve/themes/{theme}/css`

### Scripts

```text{8}
/path/to/breve
├── data
├── themes
│   └── some-theme
│       ├── css
│       ├── icons
│       ├── js
│       │   └── [Theme scripts go here]
│       └── views
└── docker-compose.yaml
```

`/path/to/breve/themes/{theme}/js`
