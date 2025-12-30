## FAQ (Frequently Asked Questions)

> 🇺🇸 English FAQ | [🇮🇳 FAQ हिंदी में](FAQ_IN.md) | [🇷🇺 ЧаВо на Русском](FAQ_RU.md) | [🇮🇹 FAQ in Italiano](FAQ_IT.md)

<details>
  <summary>Why isn’t my favicon showing up during local development?</summary>

- Open your terminal at `src/` and paste the following commands:

```bash
# This may cause use your device's password
sudo chmod 644 assets/favicon/*
sudo chmod 755 assets/favicon
```

</details>

<details>
  <summary>How do I remove <code>.DS_Store</code> files from all directories?</summary>

- First, verify the directory where `.DS_Store` files are exists:

```bash
# Delete all .DS_Store files
find . -type f -name ".DS_Store" -delete
```

```bash
# Verify if there are any leaflovers!
find . -name ".DS_Store"
```

</details>

<details>
  <summary>How do I convert PNG and JPG images to WebP?</summary>

- Make sure `ffmpeg` is installed, then run the commands from the directory containing your images.

```bash
# Convert all PNG files to WebP
  for f in *.png; do
  ffmpeg -i "$f" \
    -map_metadata -1 \
    -pix_fmt yuv444p \
    -c:v libwebp \
    -lossless 0 \
    -quality 98 \
    "${f%.png}.webp"
  done
```

```bash
# Convert all JPG files to WebP
  for f in *.jpg; do
  ffmpeg -i "$f" \
    -map_metadata -1 \
    -pix_fmt yuv444p \
    -c:v libwebp \
    -lossless 0 \
    -quality 98 \
    "${f%.jpg}.webp"
  done
```

</details>

<details>
  <summary>How do I configure Google Drive OAuth for uploads?</summary>

- Create a new Google Cloud project at `https://console.cloud.google.com` and name it: `infra-<yourdomain>`
- In Google Cloud Console, search for Google Drive API and enable it for the project.
- From the top-left ☰ menu, go to APIs & Services > Credentials.
- Fill in the following details:

```bash
#App name:
infra-<yourdomain>
#User support email:
your email address
#Audience:
choose External
#Contact Information:
your email address
```

- Click Finish, then accept: `I agree to the Google API Services.` and create.

- From the top-left ☰ menu again, go to APIs & Services > OAuth consent screen and click Create OAuth.

- Fill in the following details:

```bash
#Application type:
Web application
#Name:
infra-<yourdomain>
#Authorized Redirect URI:
https://<yourdomain>/pages/token/google_oauth_token.php
```

- Click Save and when the “OAuth client created” popup appears, copy the Client ID and Client Secret and store them in your `.env` file as `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET`.

- Next, open Audience from the left sidebar, scroll to Test users, and add the Gmail account that will be used for Google Drive storage (required for local/testing). Save the changes.

> Note: If you switch the app to Production mode, this setup will continue to work.

- Open the following URL in your browser: `https://<yourdomain>/pages/token/google_oauth_token.php`.

- Now there step 2 should show that credentials are loaded successfully. In step 3, authorize the Google Drive account you added earlier.

- After successful authorization, a refresh token will be displayed. Copy this token and paste it into your `.env` file as: `GOOGLE_REFRESH_TOKEN`.

- Finally, create (or choose) a folder in Google Drive.
- Click the folder’s three-dot menu > Share > Share, then set General access to: `Anyone with the link`.

</details>
