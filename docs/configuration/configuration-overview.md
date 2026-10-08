# Configuration Overview

## Environment Variables

Breve allows customization through configuration. You can configure Breve in a
few different ways. The simplest and _recommended_ way to configure Breve is
through environment variables. You can find a list of environment variables and
their function in the [Environment Variables](environment-variables.md)
documentation.

### Breve Compose

When using the [Breve Compose](/installation#breve-compose) installation method
environment variables should be defined in the `environment.d/breve.env` file.

::: code-group
```dotenv [breve.env]
SITE_TITLE="My Amazing Blog"
TIMEZONE="America/Phoenix"
```
:::

> [!IMPORTANT]
> After modifying `environment.d/breve.env` you must restart your containers
> (i.e. `docker compose up -d`) for the changes to apply.

### Docker Compose

For a manual [Docker Compose](/installation#docker-compose) installation, you
may define environment variables with the [`environment`](https://docs.docker.com/reference/compose-file/services/#environment)
attribute in your `docker-compose.yaml` file.

::: code-group
```yaml [docker-compose.yaml]
services:

  breve:
    image: phlak/breve:<version>
    environment: # [!code focus]
      SITE_TITLE: My Amazing Blog # [!code focus]
      TIMEZONE: America/Phoenix # [!code focus]
    ports:
      - <host_port>:80
    volumes:
      - ./data:/var/www/html/data
    restart: unless-stopped
```
:::

> [!IMPORTANT]
> After modifying your `docker-compose.yaml` file you must restart your
> containers (i.e. `docker compose up -d`) for the changes to apply.

### Docker Run

You may pass environment variables to the `docker run` command via the `--env`
flag. Multiple environment variables can be set by passing the `--env` flag
multiple times for each option.

```console
docker run --detach --publish 8080:80 --volume ./data:/var/www/html/data \
    --env SITE_TITLE="My Amazing Blog" --env TIMEZONE="America/Phoenix" \ // [!code focus]
    phlak/breve:latest
```

## Custom JavaScript and CSS

Arbitrary code like CSS & JavaScript may be included in the HTML output of your
site through the `customizations.html` file. This is particularly useful for
including analytics tracking code from [Google
Analytics](https://analytics.google.com), [Matomo
Analytics](https://matomo.org), [Umami Analytics](https://umami.is) or other
similar analytics service.

To inject your customization into your page, create a file named
`customizations.html` in the data directory and place your code into this file.

```text{4}
/path/to/breve
├── data
│   ├── [other files and folders]
│   └── customizations.html
└── docker-compose.yaml
```

::: code-group
```html [customizations.html]
<!-- Put your custom code here -->
```
:::

## Redirects

Sometimes you may need to change the slug of a page or post after it has
already been published. Doing so would break existing links pointing to the old
URL. Therefore, Breve allows you to define permanent redirects from old slugs to
new ones with the `data/redirects.yaml` file.

```text{4}
/path/to/breve
├── data
│   ├── [other files and folders]
│   └── redirects.yaml
└── docker-compose.yaml
```

Redirects are defined as `old-slug: new-slug` pairs under the `pages` and/or
`posts` keys. Only the slug itself needed. The `/page/` or `/post/` prefixes are
added automatically.

::: code-group
```yaml [redirects.yaml]
pages:
  old-page-slug: new-page-slug

posts:
  old-post-slug: new-post-slug
```
:::

In the example above, requests for `/page/an-old-page-slug` would be redirected
to `/page/a-new-page-slug`, and requests for `/post/an-old-post-slug` would be
redirected to `/post/a-new-post-slug`.

> [!NOTE]
>  Redirects are issued with a `301` (permanent) status code.

The `pages` and `posts` keys are each optional, so you may define redirects for
one or the other, or both. Likewise, the `redirects.yaml` file itself is
optional and may be omitted entirely if you have no redirects.

> [!NOTE]
> Changes to your redirects take effect immediately, there is no need to restart
> your containers.
