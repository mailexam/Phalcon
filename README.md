# Phalcon + Mailexam

Minimal [Phalcon](https://phalcon.io/) example that sends test mail through [Mailexam](https://mailexam.io/) SMTP via [phalcon/incubator-mailer](https://github.com/phalcon/incubator-mailer).

Based on the [Mailexam Phalcon guide](https://wiki.mailexam.ru/en/examples/phalcon/).

## What you need

- A Mailexam account and a project with SMTP credentials.
- PHP 8.2+ with the [Phalcon extension](https://docs.phalcon.io/5.5/installation/) and [Composer](https://getcomposer.org/).

From your Mailexam welcome email or dashboard:

| Variable | Description |
|----------|-------------|
| `MAILEXAM_LOGIN` | SMTP login (for example, `xxxxx`) |
| `MAILEXAM_PASSWORD` | SMTP password (paired with the login) |
| Host | `{MAILEXAM_LOGIN}.mailexam.io` (built in `app/Services/MailConfig.php`) |

Verify the Phalcon extension is loaded:

```bash
php -m | grep phalcon
```

## Quick start (host)

1. Install dependencies:

```bash
composer install
```

2. Copy the example environment file and fill in your credentials:

```bash
cp .env.example .env
```

3. Edit `.env`:

```env
MAILEXAM_LOGIN=YOUR_LOGIN
MAILEXAM_PASSWORD=YOUR_PASSWORD
MAILEXAM_PORT=587
MAIL_FROM=noreply@example.test
```

4. Run the built-in PHP server:

```bash
php -S 127.0.0.1:8080 -t public
```

5. Send a test message:

```bash
curl -X POST http://127.0.0.1:8080/mail/test \
  -H 'Content-Type: application/json' \
  -d '{"to":"user@example.test","subject":"Test","body":"Hello"}'
```

The message appears in the Mailexam dashboard → your project → inbox.

## Environment variables

| Variable | Required | Default | Description |
|----------|----------|---------|-------------|
| `MAILEXAM_LOGIN` | yes | — | SMTP login; also used to build the host name |
| `MAILEXAM_PASSWORD` | yes | — | SMTP password |
| `MAILEXAM_PORT` | no | `587` | SMTP port (`587`, `2525`, `465`, or `25`) |
| `MAIL_FROM` | no | `noreply@example.test` | Sender address (any test address is fine) |
| `HTTP_HOST` | no | `127.0.0.1` | HTTP bind address (Docker) |
| `HTTP_PORT` | no | `8080` | HTTP listen port |

For port **587** and **2525**, encryption is `tls`. For port **465**, it is `ssl`.

## Project layout

```
.
├── composer.json
├── app/Services/MailConfig.php
├── app/Controllers/MailController.php
├── config/routes.php
├── public/index.php              # loads .env via phpdotenv
├── .env.example
├── Dockerfile                    # for local debugging only
└── docker-compose.yml
```

## Docker (debugging)

Docker is provided for local debugging. The image includes the Phalcon extension. For day-to-day development on the host, install the extension locally (see above).

```bash
cp .env.example .env
# edit .env with your credentials

docker compose up --build
```

Then call the same endpoint on the mapped port:

```bash
curl -X POST http://127.0.0.1:8080/mail/test \
  -H 'Content-Type: application/json' \
  -d '{"to":"user@example.test","subject":"Test","body":"Hello"}'
```

Inside the container the server binds to `0.0.0.0:8080`.

## CI

Set these secrets in your CI environment (use a PHP image with the `phalcon` extension):

```yaml
variables:
  MAILEXAM_LOGIN: $MAILEXAM_LOGIN
  MAILEXAM_PASSWORD: $MAILEXAM_PASSWORD
  MAILEXAM_PORT: "587"
  MAIL_FROM: "noreply@example.test"
```

After sending a message in a test, verify delivery via the [Mailexam API](https://mailexam.io/api).

## Troubleshooting

**Class `Phalcon\...` not found**

- Install and enable the Phalcon extension for the same PHP version used in CLI and FPM.

**TLS or authentication failed**

- Host must be `{login}.mailexam.io`, where `{login}` matches `MAILEXAM_LOGIN`.
- Login and password must come from the same Mailexam project.

**Port 587**

- Requires `'encryption' => 'tls'`, not `ssl`.

**Message not in the dashboard**

- Open the inbox of the same Mailexam project.
- Enable PHPMailer debugging in the incubator-mailer config if needed.

## See also

- [Mailexam Phalcon guide (wiki)](https://wiki.mailexam.ru/en/examples/phalcon/)
- [Laravel](https://github.com/mailexam/Laravel), [Symfony](https://github.com/mailexam/Symfony), [Yii](https://github.com/mailexam/Yii), [ThinkPHP](https://github.com/mailexam/ThinkPHP) — other PHP frameworks
- [phalcon/incubator-mailer](https://github.com/phalcon/incubator-mailer)
- [Mailexam API documentation](https://mailexam.io/api)

## License

Apache 2.0
