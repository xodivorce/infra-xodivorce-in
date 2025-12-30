## FAQ (Domande frequenti)

> [🇺🇸 FAQ in English](FAQ_EN.md) | [🇮🇳 FAQ हिंदी में](FAQ_IN.md) | [🇷🇺 ЧаВо на Русском](FAQ_RU.md) | 🇮🇹 Italiano FAQ

<details>
  <summary>Perché la mia favicon non viene visualizzata durante lo sviluppo locale?</summary>

- Apri il terminale nella directory `src/` e incolla i seguenti comandi:

```bash
# Potrebbe essere richiesta la password del tuo dispositivo
sudo chmod 644 assets/favicon/*
sudo chmod 755 assets/favicon
```

</details>

<details>
  <summary>Come rimuovere i file <code>.DS_Store</code> da tutte le directory?</summary>

- Per prima cosa, verifica nelle directory dove esistono i file `.DS_Store`:

```bash
# Elimina tutti i file .DS_Store
find . -type f -name ".DS_Store" -delete
```

```bash
# Verifica se sono rimasti dei file indesiderati
find . -name ".DS_Store"
```

</details>

<details>
  <summary>Come convertire immagini PNG e JPG in WebP?</summary>

- Assicurati che `ffmpeg` sia installato, poi esegui i comandi dal terminale nella directory che contiene le immagini.

```bash
# Converti tutti i file PNG in WebP
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
# Converti tutti i file JPG in WebP
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
  <summary>Come configurare Google Drive OAuth per i caricamenti?</summary>

- Crea un nuovo progetto Google Cloud su `https://console.cloud.google.com` e chiamalo: `infra-<tuodominio>`
- Nella Google Cloud Console, cerca l'API di Google Drive e abilitala per il progetto.
- Dal menu ☰ in alto a sinistra, vai su API e servizi > Credenziali.
- Compila i seguenti dettagli:

```bash
#Nome dell'app:
infra-<tuodominio>
#Email di supporto per gli utenti:
il tuo indirizzo email
#Pubblico:
scegli Esterno
#Informazioni di contatto:
il tuo indirizzo email
```

- Clicca su Fine, poi accetta: `Accetto i servizi API di Google.` e crea.

- Dal menu ☰ in alto a sinistra, vai di nuovo su API e servizi > Schermata di consenso OAuth e clicca su Crea OAuth.

- Compila i seguenti dettagli:

```bash
#Tipo di applicazione:
Applicazione web
#Nome:
infra-<tuodominio>
#URI di reindirizzamento autorizzato:
https://<tuodominio>/pages/token/google_oauth_token.php
```

- Clicca su Salva e quando appare il popup “OAuth client creato”, copia l'ID client e il segreto client e conservali nel tuo file `.env` come `GOOGLE_CLIENT_ID` e `GOOGLE_CLIENT_SECRET`.

- Successivamente, apri Pubblico dalla barra laterale sinistra, scorri fino a Utenti di prova e aggiungi l'account Gmail che verrà utilizzato per l'archiviazione su Google Drive (richiesto per locale/test). Salva le modifiche.

> Nota: Se cambi l'app in modalità Produzione, questa configurazione continuerà a funzionare.

- Apri il seguente URL nel tuo browser: `https://<tuodominio>/pages/token/google_oauth_token.php`.

- Ora il passo 2 dovrebbe mostrare che le credenziali sono state caricate con successo. Nel passo 3, autorizza l'account Google Drive che hai aggiunto in precedenza.

- Dopo l'autorizzazione riuscita, verrà visualizzato un token di aggiornamento. Copia questo token e incollalo nel tuo file `.env` come: `GOOGLE_REFRESH_TOKEN`.

- Infine, crea (o scegli) una cartella in Google Drive.
- Clicca sul menu a tre punti della cartella > Condividi > Condividi, poi imposta l'accesso generale su: `Chiunque abbia il link`.

</details>
