# Starvion Consulting website

WordPress block theme for [starvionconsulting.com.au](https://starvionconsulting.com.au). Deep navy and silver, Source Serif 4 headings with Inter body text, and four pages: Home, Services, About and Contact.

## What's in the repo

| Path | What it is |
| --- | --- |
| `starvion/` | The theme. This folder is what gets uploaded to WordPress. |
| `starvion/theme.json` | Colours, fonts, spacing and button styles. Change the palette here. |
| `starvion/templates/` | Page layouts. `front-page.html` is the home page; `page-services.html`, `page-about.html` and `page-contact.html` match pages by their slug. |
| `starvion/patterns/` | The page sections (hero, services grid, process, and so on). Also available under **Starvion** in the block inserter. |
| `starvion/parts/` | Header and footer. |
| `starvion/inc/contact-form.php` | The contact form, used with the `[starvion_contact_form]` shortcode. |
| `bin/build-zip.sh` | Packages the theme as `starvion.zip`. |

## Install on a WordPress host

1. Run `bin/build-zip.sh`, or download the `starvion-theme` artifact from the latest **Build theme zip** run on GitHub Actions.
2. In WordPress, go to **Appearance → Themes → Add New → Upload Theme**, choose `starvion.zip` and activate it.
3. On activation the theme creates the Home, Services, About and Contact pages, sets Home as the front page, and switches permalinks to `/page-name/`.
4. Set the site title under **Settings → General**. Enquiries from the contact form go to the **Administration Email Address** on that same screen.

Requires WordPress 6.6 or later and PHP 7.4 or later.

## Editing content

All copy is editable in **Appearance → Editor → Templates**. Pick a template (for example "Services"), click into any text and type. Saved edits live in the WordPress database, so re-uploading the theme doesn't overwrite them. To bring an edit back into this repo, copy the template's code from the editor's "Code editor" view.

## Contact form email

WordPress sends mail through the host's PHP mailer, which spam filters often distrust. Before launch, install an SMTP plugin (for example WP Mail SMTP) and connect it to the inbox that will receive enquiries, then send a test enquiry.

## Placeholders to fill in before launch

- Founder name, title, photo and bio (About page)
- Email, phone, city and LinkedIn link (Contact page and footer)
- ABN (footer)
- Industries list (Home page)
- Logo: the header currently uses a text wordmark. Swap in a Site Logo block once the logo is final.
