# The Sustainable Theme — Handleiding

**Door Pixel to Planet · pixeltoplanet.earth**  
**Versie 0.2.4**

---

> Hey! Welkom bij The Sustainable Theme. Dit is de officiële handleiding voor creatieve professionals die zelf hun website willen bouwen — zonder code, zonder gedoe, maar mét resultaat. We houden het zo praktisch mogelijk, dus geen technisch jargon. Gewoon: wat doe je als eerste, wat daarna, en hoe ziet je site er straks uit.

---

## Inhoudsopgave

1. [Wat is The Sustainable Theme?](#1-wat-is-the-sustainable-theme)
2. [Waarom duurzaam?](#2-waarom-duurzaam)
3. [Downloaden en uploaden](#3-downloaden-en-uploaden)
4. [Eerste stappen na activatie](#4-eerste-stappen-na-activatie)
5. [Je huisstijl instellen — kleurenpalet](#5-je-huisstijl-instellen--kleurenpalet)
6. [Lettertypen toevoegen](#6-lettertypen-toevoegen)
7. [Spacing en afstanden](#7-spacing-en-afstanden)
8. [Ronde hoeken instellen (Design Settings)](#8-ronde-hoeken-instellen-design-settings)
9. [Wat zijn block patterns en waarom gebruik je ze?](#9-wat-zijn-block-patterns-en-waarom-gebruik-je-ze)
10. [Het patronenbibliotheek van de theme](#10-het-patronenbibliotheek-van-de-theme)
11. [De meestgebruikte blocks](#11-de-meestgebruikte-blocks)
12. [Je eerste pagina bouwen](#12-je-eerste-pagina-bouwen)
13. [Header en footer aanpassen](#13-header-en-footer-aanpassen)
14. [Duurzaamheidsinstellingen](#14-duurzaamheidsinstellingen)
15. [Grid Awareness — real-time koolstofmeting](#15-grid-awareness--real-time-koolstofmeting)
16. [Aanbevolen plugins](#16-aanbevolen-plugins)
17. [Database opruimen](#17-database-opruimen)
18. [Je website lanceren](#18-je-website-lanceren)
19. [Updates ontvangen](#19-updates-ontvangen)

---

## 1. Wat is The Sustainable Theme?

The Sustainable Theme is een WordPress-thema gemaakt door Pixel to Planet. Het is gebouwd voor creatieve professionals — fotografen, designers, freelancers, kleine bureaus — die een strak, modern portfolio of bedrijfssite willen bouwen.

Het thema maakt gebruik van het **Full Site Editing (FSE)** systeem van WordPress. Dat betekent: je bouwt je complete website — van koptekst tot voettekst, van paginatemplates tot navigatiemenu's — via de visuele **Site Editor** in WordPress. Geen apart thema-customizer, geen shortcodes, gewoon blokken slepen en klikken.

**Wat maakt dit thema anders dan andere WordPress-thema's?**

- Het heeft een ingebouwde bibliotheek van **78 kant-en-klare pagina-secties en volledige paginalay-outs** (zogenoemde *patterns*). Daarmee bouw je een professionele pagina in minuten in plaats van uren.
- Het bevat een **duurzaamheidsoptimizer** die automatisch overbodige WordPress-scripts, databases en overhead verwijdert. Je site wordt sneller én beter voor het milieu.
- Het designsysteem is gebouwd op **design tokens**: vaste kleuren, lettergroottes en spacings die overal consistent worden toegepast. Verander je één kleur, dan verandert die op je hele site.
- De typografie is gebaseerd op **DM Sans**, een variabel lettertype dat al ingebakken zit. Je hoeft niets apart te laden.

---

## 2. Waarom duurzaam?

Het internet verbruikt meer stroom dan veel landen. Elke website die laadt kost energie — voor de server die hem verstuurt, het netwerk dat hem transporteert, en het apparaat van je bezoeker. The Sustainable Theme is ontworpen om dat verbruik structureel te verlagen.

**Wat doet het concreet?**

- Verwijdert automatisch onnodige WordPress-scripts (emoji's, embeds, jQuery-migratie). Dat scheelt al **30KB+ per paginalading**.
- Beperkt afbeeldingen tot wat écht geladen hoeft te worden via **lazy loading**.
- Houdt de database schoon via een **wekelijkse automatische opruimronde**: verouderde revisies, verlopen tijdelijke data, weesgekoppelde metagegevens — weg.
- Optioneel: via de **Grid Awareness**-functie kan je site de actuele CO₂-intensiteit van het elektriciteitsnet monitoren en bezoekers hierover informeren.

**Wat zijn de resultaten in de praktijk?**

Uit gebruik in de praktijk blijkt dat sites met The Sustainable Theme **15–45% minder CO₂ uitstoten per paginalading** vergeleken met een standaard WordPress-installatie. Een site met 22 miljoen bezoeken per jaar reduceerde zo de uitstoot van 1,13 gram naar 0,39 gram CO₂ per paginabezoek — een besparing van **16 ton CO₂ per jaar**.

Duurzaamheid is hier geen marketingterm. Het is ingebakken in de code.

---

## 3. Downloaden en uploaden

### Stap 1 — Download de theme

Ga naar [pixeltoplanet.earth/the-sustainable-theme](https://pixeltoplanet.earth/the-sustainable-theme) en download de meest recente versie van het thema als `.zip`-bestand.

> **Let op:** download altijd de officiële release. Gebruik je een ontwikkelversie direct van GitHub, dan moet je zelf de assets bouwen (dat is voor developers). De kant-en-klare download werkt direct.

### Stap 2 — Upload naar WordPress

1. Log in op je WordPress-dashboard (`jouwsite.nl/wp-admin`)
2. Ga naar **Weergave → Thema's** (of **Appearance → Themes** als je WordPress in het Engels hebt)
3. Klik op **Nieuw thema toevoegen → Thema uploaden**
4. Klik op **Bestand kiezen**, selecteer het `.zip`-bestand dat je net hebt gedownload
5. Klik op **Nu installeren**
6. Klik daarna op **Activeer thema**

WordPress installeert nu het thema. Even geduld.

### Stap 3 — Controleer of alles werkt

Na activatie zie je bovenaan het dashboard een nieuw menu-item verschijnen: **Sustainable Theme**. Als je dat ziet, is de installatie gelukt.

Ga ook even naar de voorkant van je site (klik op "Bezoek site" rechtsboven in het dashboard). Je ziet nu een clean, leeg canvas — klaar om in te vullen.

---

## 4. Eerste stappen na activatie

Voordat je begint met bouwen, doorloop je deze stappen in volgorde. Dit is de logische volgorde — je bouwt eerst het fundament, dan de muren, dan de inrichting.

| Stap | Wat doe je | Waar |
|------|-----------|------|
| 1 | Duurzaamheidsmodus kiezen | Sustainable Theme → Sustainability |
| 2 | Kleurenpalet instellen | Weergave → Editor → Stijlen |
| 3 | Lettertype instellen | Weergave → Editor → Stijlen |
| 4 | Spacing controleren | Weergave → Editor → Stijlen |
| 5 | Ronde hoeken instellen | Sustainable Theme → Design |
| 6 | Logo uploaden | Weergave → Editor → Header |
| 7 | Navigatiemenu aanmaken | Weergave → Editor → Header |
| 8 | Eerste pagina bouwen | Pagina's → Nieuwe pagina |
| 9 | Homepage instellen | Instellingen → Lezen |
| 10 | Site lanceren | Instellingen → Algemeen + hostingpanel |

We lopen elke stap door in de rest van deze handleiding.

---

## 5. Je huisstijl instellen — kleurenpalet

Dit is je eerste échte taak. De kleuren die je hier instelt, worden overal op je site gebruikt: in knoppen, achtergronden, tekst, randen, alles. Doe dit goed en de rest valt op zijn plek.

### Hoe werkt het kleurensysteem?

The Sustainable Theme werkt met **8 kleurrollen**. Elke rol heeft een naam en een functie:

| Kleurrol | Standaardkleur | Gebruik |
|----------|---------------|---------|
| **Background** | Wit `#FFFFFF` | Achtergrond van de site |
| **Foreground** | Zwart `#000000` | Standaard tekstkleur |
| **Neutral 1** | Lichtgrijs `#D8D8D8` | Subtiele randen, achtergronden |
| **Neutral 2** | Middengrijs `#7F7F7F` | Secondaire tekst, ondertitels |
| **Primary** | Fel groen `#00FF00` | Je hoofdaccentkleur |
| **Secondary** | Blauw `#0000DB` | Knopkleur, links |
| **Tertiary** | Oranje `#FF6600` | Derde accentkleur |
| **Accent** | Geel `#FFFF00` | Highlights, tags, badges |

De standaardkleuren zijn bewust krachtig en contrastrijk ingesteld — dat zijn placeholders. Vervang ze door de kleuren van jouw merk.

### Je kleuren aanpassen

1. Ga naar **Weergave → Editor** (de Site Editor)
2. Klik linksboven op het WordPress-logo en kies **Stijlen** — of klik op het cirkelicoon rechts bovenin de editor
3. Klik op **Kleuren** → **Palet**
4. Onder **Thema** zie je de 8 kleurrollen
5. Klik op een kleurblokje om de kleur te wijzigen — voer een hex-code in of gebruik de kleurkiezer
6. Klik rechts bovenin op **Opslaan**

> **Tip:** Begin bij Primary, Secondary en Background. Die worden het meest gebruikt door de patterns. Tertiary en Accent zijn leuk voor details maar niet essentieel als je net begint.

### Stijlvarianten — kant-en-klare kleurpaletten

Het thema bevat 6 complete kleurpaletten die je direct kunt toepassen:

- **Sustainable** — aard-tonen, groen en naturel
- **Ocean** — blauw, aqua, koel
- **Rustique** — warm, terracotta, vintage
- **Sunset** — warm, oranje, rood
- **Pastel** — zacht, luchtig, vriendelijk
- **Cyberpunk** — donker, neon, gedurfd

Je vindt ze via **Weergave → Editor → Stijlen → Doorbladerbare stijlen**. Klik op een variant om direct de preview te zien. Kies je er eentje als basis, dan kun je daarna nog altijd losse kleuren aanpassen.

---

## 6. Lettertypen toevoegen

Het thema gebruikt standaard **DM Sans** — een modern, schoon schreefloos lettertype dat zowel voor koppen als lopende tekst werkt. DM Sans is al ingebakken in het thema, zodat je niks extra hoeft te laden.

### DM Sans gebruiken (standaard)

Als je DM Sans prima vindt, hoef je niets te doen. Het thema past het automatisch toe op alle tekst.

### Een Google Font toevoegen

Wil je jouw eigen lettertype gebruiken? Dat kan via WordPress zelf:

1. Ga naar **Weergave → Editor**
2. Klik linksboven op het logo → **Lettertypen**
3. Klik op **Google Fonts** en zoek naar je lettertype
4. Klik op het lettertype → **Lettertype activeren**
5. Ga daarna terug naar **Stijlen → Typografie**
6. Kies het geactiveerde lettertype als **Tekst** (voor broodtekst) of **Kopteksten**

> **Let op voor duurzaamheid:** Elk extra lettertype dat je laadt kost bandbreedte. Kies bij voorkeur één lettertype voor alles, of maximaal twee (één voor koppen, één voor tekst). Variabele lettertypen (zoals DM Sans) zijn de meest efficiënte keuze — één bestandje ondersteunt alle diktes.

### Lettergroottes

Het thema heeft 7 vooraf ingestelde lettergroottes die je kunt toewijzen aan tekstelementen:

| Naam | Gebruik |
|------|---------|
| **XS** | Bijschriften, credits, kleine labels |
| **SM** | Kleine lopende tekst |
| **MD** | Standaard broodtekst |
| **LG** | Intro-alinea's, citaten |
| **XL** | Ondertitels van secties |
| **XXL** | Paginakoppen, grote headings |
| **XXXL** | Titels die de aandacht moeten trekken |

Alle groottes zijn **fluid**: ze schalen vloeiend mee van mobiel naar desktop. Je hoeft je geen zorgen te maken over aparte mobiele instellingen.

---

## 7. Spacing en afstanden

Spacing gaat over de ruimte tussen en om elementen heen. Het thema heeft 5 fluid spacing-waarden:

| Naam | Gebruik |
|------|---------|
| **Fluid X-Small** | Kleine tussenruimtes, bijv. icoon-to-tekst |
| **Fluid Small** | Ruimte rondom tekst, padding in secties |
| **Fluid Medium** | Standaard ruimte tussen secties |
| **Fluid Large** | Grotere ademruimte, luxe uitstraling |
| **Fluid X-Large** | Grote secties, hero-achtige ruimtes |

Deze spacings zijn ook **clamp-based**: ze schalen automatisch mee met het scherm. Op een grote monitor is de ruimte iets groter, op mobiel iets kleiner — dat voelt altijd goed aan.

**Je hoeft deze waarden normaal gesproken niet te veranderen.** De patterns gebruiken ze al op de juiste plekken. Maar als je bij een specifiek blok extra ruimte wilt toevoegen, kies dan altijd één van deze 5 waarden in de afstands-instellingen van dat blok. Zo blijft alles consistent.

---

## 8. Ronde hoeken instellen (Design Settings)

Het thema heeft een speciaal Design Settings-paneel waar je de ronding van hoeken van kaarten, afbeeldingen en knoppen kunt instellen. Dit is een van de snelste manieren om je site een eigen karakter te geven.

1. Ga naar **Sustainable Theme → Design** in het WordPress-dashboard
2. Je ziet drie schuifregelaars:
   - **Card radius** — ronding van kaarten en containers (standaard: 15px)
   - **Image radius** — ronding van afbeeldingen (standaard: 15px)
   - **Button radius** — ronding van knoppen (standaard: 4px)
3. Pas de waarden aan naar jouw smaak
4. Klik op **Opslaan**

> **Tip voor uitstraling:**
> - Veel afronding (20–30px) = vriendelijk, modern, speels
> - Weinig afronding (2–6px) = zakelijk, strak, professioneel
> - Geen afronding (0px) = minimalistische uitstraling, editorial-gevoel
> - Volledige ronding op knoppen (50–100px) = pillenknop-stijl

De waarden die je hier instelt worden toegepast op **al je afbeeldingen, kaarten en knoppen tegelijk** — op je hele site.

---

## 9. Wat zijn block patterns en waarom gebruik je ze?

Dit is het belangrijkste hoofdstuk van deze handleiding. Lees het goed.

### Wat zijn blocks?

WordPress werkt met **blokken** (blocks). Elk stukje inhoud is een blok: een alinea is een blok, een afbeelding is een blok, een knop is een blok. Blokken kun je op een lege pagina plaatsen en naar wens combineren.

Standaard begin je met een lege pagina en voeg je blokken één voor één toe. Dat werkt, maar het kost veel tijd en je moet zelf alles in evenwicht brengen — opmaak, kleuren, verhoudingen, spacing.

### Wat zijn patterns (patronen)?

**Patterns** zijn kant-en-klare combinaties van blokken, al gestyled, al in de juiste verhoudingen, klaar voor gebruik. Denk aan:

- Een hero-sectie met een grote koptekst, ondertitel, en twee knoppen
- Een rij van drie dienstkaarten met icoon, titel, en beschrijving
- Een portfolio-grid van zes projecten met hover-effect
- Een complete contactpagina met formulierruimte, adresblok, en pictogrammen

In plaats van dat je deze secties zelf bouwt blokje voor blokje, plak je een pattern neer en je hebt het resultaat direct. Je past dan alleen de tekst, afbeeldingen en links aan.

### Waarom zijn patterns beter dan losse blokken?

| Losse blokken | Patterns |
|--------------|----------|
| Alles zelf opbouwen | Direct een professioneel resultaat |
| Kans op inconsistentie in opmaak | Consistent met de rest van je site |
| Veel tijd kwijt met spacing en kleuren | Kleuren en spacing zijn al goed ingesteld |
| Moeilijk om een professionele uitstraling te krijgen | Professioneel ontwerp als vertrekpunt |

> **Onze aanpak:** Gebruik altijd een pattern als startpunt, ook al past het niet 100% bij wat je wilt. Pas daarna aan. Zo ben je sneller en eindigt je site consistenter.

### Hoe gebruik je patterns?

**Op een pagina:**

1. Open een pagina in de editor (of maak een nieuwe)
2. Klik op het **+**-icoon links bovenin de editor (of in de inhoud)
3. Klik op het tabje **Patronen**
4. Blader door de categorieën of zoek naar een patroon
5. Klik op een patroon om het toe te voegen

**Een complete pagina als patroon:**

1. Maak een nieuwe lege pagina
2. Klik op het **+**-icoon → **Patronen**
3. Kies de categorie **Pages**
4. Klik op een complete pagina-layout
5. De hele pagina wordt in één keer gevuld

### Patterns bewerken

Na het toevoegen van een pattern kun je elk blok daarin gewoon klikken en aanpassen. Tekst vervangen, afbeelding wijzigen, knop aanpassen — het werkt hetzelfde als elk ander blok.

> **Let op:** Patterns zijn bij het invoegen "losgekoppeld" van het origineel. Als je later een pattern aanpast in de patronenbibliotheek, verandert het **niet** op pagina's waar je het al hebt gebruikt. Patterns zijn eerder een startpunt dan een levend systeem.

---

## 10. Het patronenbibliotheek van de theme

The Sustainable Theme heeft **78 patterns**, verdeeld over 13 categorieën. Hier is een overzicht van wat er beschikbaar is.

### Pages — volledige paginalay-outs

Dit zijn de meest krachtige patterns. Ze vullen een complete pagina met meerdere secties — perfect als startpunt voor een nieuwe pagina.

| Pattern | Omschrijving |
|---------|-------------|
| **Page home 01** | Bureauwebsite: hero, diensten, statistieken, afbeelding, testimonials, posts, prijzen, CTA |
| **Page home 02** | Alternatieve homepagina-layout |
| **Page about 01–03** | Drie verschillende over-ons-paginalay-outs |
| **Page contact 01** | Gesplitste contactpagina: hero links, formulierruimte rechts |
| **Page contact 02** | Gecentreerde contactpagina met formulier en pictogrammen |
| **Page portfolio home 01–03** | Portfolio-homepagina's in verschillende stijlen |
| **Page post overview 01–02** | Blogoverzichtspagina's |
| **Single post full 01–02** | Volledige lay-out voor een blogbericht |

### Hero — de openingssectie van een pagina

De hero is het eerste dat bezoekers zien. Het thema heeft vele smaken:

| Pattern | Stijl |
|---------|-------|
| **Hero overlay dark** | Grote afbeelding met donkere overlay en witte tekst |
| **Hero cover bottom** | Afbeelding als achtergrond, tekst onderaan |
| **Hero cover boxed** | Omlijnd kader over een cover-afbeelding |
| **Hero cover centered** | Gecentreerde tekst op een cover |
| **Hero simple page intro** | Lichte intro zonder afbeelding, puur typografisch |
| **Hero split text** | Twee kolommen: grote tekst links, kleinere tekst rechts |
| **Hero split image** | Tekst links, grote afbeelding rechts |
| **Hero asymmetric** | Asymmetrisch, dynamisch compositie |
| **Hero bent** | Speelse gebogen lay-out |

### Content — tussenliggende secties

| Pattern | Gebruik |
|---------|---------|
| **Intro text** | Brede, prominente introtekst |
| **Intro section** | Introsectie met kop en subtekst |
| **Content simple narrow** | Smalle tekstkolom, ideaal voor lange tekst |
| **Content simple two col** | Tekst in twee kolommen |
| **Content quote** | Groot citaat als sectie-element |
| **Content big number** | Statistiek met groot getal en label |
| **Content with image left/right** | Tekst naast afbeelding |
| **Content with image narrow left/right** | Smallere versie met tekst en afbeelding naast elkaar |
| **Content with image vertical** | Afbeelding boven of onder tekst |

### Services — diensten en functies tonen

| Pattern | Stijl |
|---------|-------|
| **Service cards simple** | Eenvoudige tekstkaarten |
| **Service cards icon** | Kaarten met pictogram bovenaan |
| **Service cards with image 2 cols** | Twee kolommen, afbeelding in elke kaart |
| **Service cards with image 3 cols** | Drie kolommen met afbeeldingen |
| **Service cards with image grid 3 cols** | Grid-indeling, drie kolommen |

### Posts — blogberichten tonen

| Pattern | Gebruik |
|---------|---------|
| **Posts grid 2 columns** | Twee-koloms grid van berichten |
| **Posts grid 3 columns** | Drie-koloms grid |
| **Posts grid 4 columns** | Compact vier-koloms grid |
| **Posts masonry** | Vrije hoogte, Pinterest-achtige layout |
| **Posts masonry 3 columns** | Masonry in drie kolommen |
| **Posts featured grid** | Uitgelicht bericht + kleinere grid |

### Portfolio — projecten tonen

Meerdere portfolio-grid patterns, vergelijkbaar met de posts-patterns maar visueel zwaarder ingezet op afbeeldingen.

### Gallery — fotogalerijen

| Pattern | Gebruik |
|---------|---------|
| **Gallery grid** | Regelmatig afbeeldingsgrid |
| **Gallery masonry** | Vrije hoogtes, organisch gevoel |
| **Gallery masonry narrow** | Smaller formaat masonry |
| **Gallery 4 columns auto height** | Vier kolommen, hoogte past zich aan |

### CTA — call-to-action

| Pattern | Gebruik |
|---------|---------|
| **CTA banner simple** | Eenvoudige brede banner met knop |
| **CTA banner centered** | Gecentreerde banner |

### Contact

De contactpatronen bevatten **geen ingebouwde formulieren**. Ze bevatten een duidelijke placeholder-aanwijzing waar je jouw eigen contactformulier-plugin moet invoegen (zoals WPForms, Gravity Forms, of Contact Form 7).

### Header en Footer

| Pattern | Gebruik |
|---------|---------|
| **Header simple** | Logo links, navigatie rechts |
| **Header centered** | Logo en nav gecentreerd |
| **Header with tagline** | Logo + tagline + navigatie |
| **Header with topbar** | Bovenste informatiebalk + header |
| **Footer simple** | Simpele footer met kolommen |

---

## 11. De meestgebruikte blocks

Binnen de patterns van het thema kom je telkens dezelfde blocks tegen. Hier is een uitleg van elk blok, waarvoor het gebruikt wordt in dit thema, en een link naar de officiële WordPress-documentatie.

---

### Group (Groep)

**Wat het is:** Een container die andere blokken omhult. Gebruik het als sectie-wrapper om achtergrondkleur, padding, en uitlijning toe te passen op een hele sectie.

**Hoe het gebruikt wordt in dit thema:** Vrijwel elke sectie in een pattern is een Group-blok. Het Group-blok bepaalt de breedte, de achtergrondkleur, en de verticale ruimte van een sectie.

[→ WordPress-documentatie: Group](https://wordpress.org/documentation/article/group/)

---

### Columns & Column

**Wat het is:** Verdeelt de inhoud in meerdere naast elkaar staande kolommen.

**Hoe het gebruikt wordt:** Diensten naast elkaar, tekst naast afbeelding, portfolio-grid — al deze lay-outs gebruiken Columns.

[→ WordPress-documentatie: Columns](https://wordpress.org/documentation/article/columns/)

---

### Heading (Koptekst)

**Wat het is:** Koppen van niveau H1 t/m H6.

**Hoe het gebruikt wordt:** In dit thema zijn er stijlvarianten voor headings:
- **Subtitle** — voor ondertitels van secties
- **Display** — voor grote titels die enorm uit de verf moeten komen
- **Annotation** — voor kleine annotaties of labels

Kies een variant via het zijpaneel → **Stijlen** na het selecteren van een heading.

[→ WordPress-documentatie: Heading](https://wordpress.org/documentation/article/heading/)

---

### Paragraph (Alinea)

**Wat het is:** Standaard lopende tekst.

**Hoe het gebruikt wordt:** Alle bodytekst. Ook de **Subtitle** en **Annotation** stijlvarianten zijn beschikbaar op alinea's, niet alleen op headings.

[→ WordPress-documentatie: Paragraph](https://wordpress.org/documentation/article/paragraph/)

---

### Image (Afbeelding)

**Wat het is:** Voegt een afbeelding in vanuit de mediabibliotheek of externe URL.

**Hoe het gebruikt wordt:** In portfolio-kaarten, naast tekst in content-secties, in galerijen. De ronding van afbeeldingen volgt automatisch de **Image radius** die je in Design Settings hebt ingesteld.

[→ WordPress-documentatie: Image](https://wordpress.org/documentation/article/image/)

---

### Cover

**Wat het is:** Een afbeelding of video als achtergrond, met inhoud eroverheen.

**Hoe het gebruikt wordt:** Hero-secties, grote intro-secties met overlay. Dit is het meest impactvolle blok voor een sterke openingsindruk.

[→ WordPress-documentatie: Cover](https://wordpress.org/documentation/article/cover/)

---

### Buttons & Button

**Wat het is:** Klikbare knoppen.

**Hoe het gebruikt wordt:** Call-to-action knoppen onderaan secties. Het thema heeft twee knopstijlen:
- **Standaard** (gevuld) — gebruikt de Secondary-kleur als achtergrond
- **Outline** — transparante knop met rand, voor een secundaire actie naast een gevulde knop

[→ WordPress-documentatie: Buttons](https://wordpress.org/documentation/article/buttons/)

---

### Navigation (Navigatie)

**Wat het is:** Het navigatiemenu van je site.

**Hoe het gebruikt wordt:** Altijd in de header-template. Je maakt je menustructuur aan via de Site Editor → Header → klik op het Navigatie-blok.

> **Eerste keer instellen:** Klik op het Navigatie-blok in de header → voeg paginalinks toe. WordPress slaat je menu automatisch op.

[→ WordPress-documentatie: Navigation](https://wordpress.org/documentation/article/navigation/)

---

### Site Logo

**Wat het is:** Het logo van je website, zoals ingesteld in de WordPress-instellingen.

**Hoe het gebruikt wordt:** In alle header-patterns. Upload je logo via **Weergave → Editor → Header → klik op het logo-blok**.

[→ WordPress-documentatie: Site Logo](https://wordpress.org/documentation/article/site-logo/)

---

### Query Loop

**Wat het is:** Een automatisch bijgewerkt overzicht van berichten, gefilterd op categorie, tag, datum, etc.

**Hoe het gebruikt wordt:** Alle "Posts"-patterns in het thema gebruiken een Query Loop. Je stelt in welke berichten worden getoond en hoe ze eruitzien.

**Thema-uitbreiding:** Het thema voegt een extra optie toe aan de Query Loop: **"Huidige post uitsluiten"**. Als je een gerelateerde posts-sectie op een blogbericht-pagina zet, zorgt deze optie dat het bericht dat je op dit moment leest, niet in de lijst verschijnt.

[→ WordPress-documentatie: Query Loop](https://wordpress.org/documentation/article/query-loop-block/)

---

### Gallery (Galerij)

**Wat het is:** Een grid van meerdere afbeeldingen tegelijk.

**Hoe het gebruikt wordt:** In portfolio- en galerij-secties. Het thema heeft ook masonry-patronen die de gallery visueel vrijer maken.

[→ WordPress-documentatie: Gallery](https://wordpress.org/documentation/article/gallery/)

---

### Quote (Citaat)

**Wat het is:** Een opgemaakt citaat.

**Hoe het gebruikt wordt:** Voor testimonials, klantcitaten, en opvallende uitspraken binnen een pagina.

[→ WordPress-documentatie: Quote](https://wordpress.org/documentation/article/quote/)

---

### List (Lijst)

**Wat het is:** Opsomming met bullets of nummers.

**Hoe het gebruikt wordt:** In prijzensecties (features per abonnement), in dienstenpagina's.

[→ WordPress-documentatie: List](https://wordpress.org/documentation/article/list/)

---

### Separator (Scheidingslijn)

**Wat het is:** Een horizontale lijn om secties van elkaar te scheiden.

**Thema-stijlen:**
- **1px content-breedte** — subtiele lijn binnen de content-breedte
- **2px smal** — iets prominenter, smaller
- **4px volledig** — brede, opvallende lijn over de volledige breedte

[→ WordPress-documentatie: Separator](https://wordpress.org/documentation/article/separator/)

---

### Post Featured Image, Post Title, Post Date, Post Excerpt

Deze vier blokken zijn **context-afhankelijk**: ze werken alleen binnen een Query Loop of op een enkel-bericht-template. Ze halen automatisch de gegevens op van het bericht dat op dat moment wordt weergegeven.

| Blok | Haalt op |
|------|---------|
| **Post Featured Image** | De uitgelichte afbeelding van het bericht |
| **Post Title** | De titel van het bericht |
| **Post Date** | De publicatiedatum |
| **Post Excerpt** | De samenvatting van het bericht |

**Thema-uitbreiding:** Het thema voegt een optie toe aan het Post Excerpt-blok: **"Lees meer-link verbergen"**. Zo toon je alleen de samenvatting, zonder de automatische "Lees meer"-knop eronder.

---

## 12. Je eerste pagina bouwen

Nu je huisstijl staat, is het tijd om je eerste pagina te bouwen. We nemen een homepage als voorbeeld.

### Stap 1 — Maak een nieuwe pagina aan

1. Ga naar **Pagina's → Nieuwe pagina toevoegen**
2. Geef de pagina de naam "Home"
3. Klik **nog niet** op publiceren

### Stap 2 — Voeg een complete pagina-layout toe

1. Klik op het **+**-icoon linksboven in de editor
2. Klik op het tabje **Patronen**
3. Zoek de categorie **Pages**
4. Kies een patroon dat bij je stijl past, bijv. **Page home 01**
5. Klik erop — de volledige pagina wordt gevuld

### Stap 3 — Pas de tekst aan

Klik op elke koptekst, alinea, en knoptekst en vervang de placeholder-tekst door jouw eigen inhoud.

> **Tip:** Begin met de hero — dat is de eerste sectie die bezoekers zien. Zorg dat jouw naam/merknaam, tagline, en een duidelijke call-to-action (knop) er al in staan voordat je verder gaat.

### Stap 4 — Pas de afbeeldingen aan

1. Klik op een placeholder-afbeelding
2. Klik op het afbeelding-pictogram in de werkbalk → **Vervangen**
3. Upload je eigen afbeelding of kies er een uit de mediabibliotheek

### Stap 5 — Verwijder secties die je niet nodig hebt

Heb je geen prijzentabel? Klik op de prijzensectie → selecteer het buitenste Group-blok → druk op Backspace of klik op **Verwijderen** in de werkbalk.

### Stap 6 — Voeg extra secties toe

Wil je een sectie toevoegen die er niet in zit?

1. Klik op de **+** tussen twee secties
2. Kies **Patronen**
3. Kies een losse sectie, bijv. een diensten-pattern of een portfolio-pattern
4. Het wordt ingevoegd op die plek

### Stap 7 — Publiceer en stel in als homepage

1. Klik rechts bovenin op **Publiceren**
2. Ga naar **Instellingen → Lezen**
3. Kies bij "Uw startpagina toont" voor **Een statische pagina**
4. Stel **Startpagina** in op "Home"
5. Klik op **Wijzigingen opslaan**

---

## 13. Header en footer aanpassen

De header en footer zijn **template-onderdelen** (template parts). Ze worden gedeeld door alle pagina's — verander je de header op één plek, verandert hij overal.

### Header bewerken

1. Ga naar **Weergave → Editor**
2. Klik linksboven op het logo → kies **Sjabloononderdelen** (of **Template Parts**)
3. Klik op **Header**
4. De header opent in de editor

Wat je kunt aanpassen:
- **Logo:** Klik op het logo-blok → upload jouw logo
- **Navigatie:** Klik op het navigatieblok → voeg paginalinks toe of pas de bestaande aan
- **Stijl:** Wil je een andere header-stijl? Verwijder de huidige inhoud en voeg een header-patroon in via **+ → Patronen → Header**

> **Eerste keer navigatie instellen:** De header bevat standaard een navigatieblok. Klik erop, klik op **Bewerken**, en voeg je paginalinks toe. Je kunt pagina's zoeken via naam.

### Footer bewerken

Zelfde werkwijze als de header, maar kies **Footer** in de sjabloononderdelen. De standaard footer is eenvoudig — wil je meer kolommen, verwijder de inhoud en voeg een footer-patroon in.

---

## 14. Duurzaamheidsinstellingen

Ga naar **Sustainable Theme → Sustainability** om de duurzaamheidsinstellingen te configureren.

### De drie modi

#### Base Mode — aanbevolen voor de meeste sites

Dit is de standaardinstelling. Veilig voor alle sites, inclusief webshops. Wat het doet:

- Emoji-scripts verwijderd (bespaart laadtijd)
- Oembed-embeds uitgeschakeld (geen auto-preview van YouTube etc. in berichten)
- WordPress-headerrommeltje opgeruimd
- jQuery Migrate uitgeschakeld
- Kortlinks uitgeschakeld
- Post-revisies beperkt tot 5
- Query strings van CSS/JS-bestanden verwijderd (betere caching)
- Bestandsbewerking in dashboard uitgeschakeld (veiliger)
- Lazy loading aan (2 afbeeldingen boven de vouw laden direct)
- Afbeeldingsoptimalisatie aan
- Video-autoplay uitgeschakeld

#### Super Mode — voor blogs en contentwebsites

Alles van Base Mode, plus:

- Scripts verwijderd die niet nodig zijn
- RSS-feeds uitgeschakeld
- REST-links uit de header verwijderd
- XML-RPC uitgeschakeld
- WordPress Heartbeat uitgeschakeld
- Reactiessysteem uitgeschakeld
- WordPress-versienummer verborgen
- DNS-prefetch uitgeschakeld
- Dashicons op de frontend uitgeschakeld
- Gravatar vervangen door een lichte SVG-placeholder
- Automatische updates uitgeschakeld
- Revisies beperkt tot 3
- Standaard WordPress-afbeeldingsgroottes verwijderd

> **Let op:** Super Mode schakelt Reacties volledig uit. Gebruik Base Mode als je reacties op je blog wilt bijhouden.

#### Custom Mode — voor gevorderden

Met Custom Mode zet je elke individuele instelling aan of uit. Handig als je de meeste Base Mode-instellingen wilt, maar bijv. RSS-feeds wél nodig hebt.

### Welke modus kies ik?

| Type website | Aanbevolen modus |
|-------------|-----------------|
| Portfolio, visitekaartje | Super Mode |
| Blog met reacties | Base Mode |
| Webshop | Base Mode |
| Zakelijke website | Base Mode of Super Mode |
| Persoonlijk project | Super Mode |

---

## 15. Grid Awareness — real-time koolstofmeting

Dit is een geavanceerde optionele functie. Met **Grid Awareness** monitort je site in realtime de CO₂-intensiteit van het lokale elektriciteitsnet. Op momenten dat het net meer op hernieuwbare energie draait, kan de site dit aan bezoekers laten zien.

### Instellen

1. Ga naar **Sustainable Theme → Sustainability → Grid Awareness**
2. Schakel Grid Awareness in
3. Maak een gratis account aan op [electricitymaps.com](https://electricitymaps.com)
4. Kopieer je API-sleutel en plak hem in het veld **Electricity Maps API Key**
5. Sla op

### Wat zie je dan?

De site toont een subtiele kleur-indicator die aangeeft of het net op dit moment schoner of vuiler is dan gemiddeld. Het is een transparante manier om bezoekers te laten zien dat jij om duurzaamheid geeft.

> Op een localhost (lokale ontwikkelomgeving) toont het thema automatisch voorbeelddata, zodat je de functie kunt testen zonder echte API-verbinding.

---

## 16. Aanbevolen plugins

Ga naar **Sustainable Theme → Theme Settings** voor een overzicht van aanbevolen plugins die de duurzaamheid en prestaties van je site verder verbeteren. Je installeert ze met één klik:

| Plugin | Functie |
|--------|---------|
| **Smush** | Afbeeldingen automatisch comprimeren |
| **LiteSpeed Cache** | Geavanceerde paginacaching |
| **WP-Optimize** | Database opruimen en optimaliseren |
| **Autoptimize** | CSS en JavaScript minificeren |

> **Gebruik je al een caching-plugin van je hostingprovider?** Dan hoef je LiteSpeed Cache of Autoptimize mogelijk niet te installeren. Vraag je hostingprovider wat al inbegrepen is.

---

## 17. Database opruimen

WordPress slaat van alles op dat je eigenlijk nooit meer nodig hebt: oude revisies van je berichten, verlopen tijdelijke bestanden, stukgelopen metagegevens. Dat maakt je database groter en langzamer.

The Sustainable Theme ruimt dit **automatisch elke week op** via een geplande taak op de achtergrond. Je hoeft er niets voor te doen.

Wil je handmatig opruimen?

1. Ga naar **Sustainable Theme → Sustainability**
2. Scroll naar het gedeelte **Database Cleanup**
3. Klik op **Run Database Cleanup Now**

Wat er opgeruimd wordt:
- Overtollige post-revisies
- Verlaten concepten ouder dan 7 dagen
- Weesgekoppelde metadata
- Verlopen tijdelijke cachegegevens

---

## 18. Je website lanceren

Alles staat? Mooi. Hier is de definitieve lanceerlijst.

### Voorbereiding

- [ ] Homepage is aangemaakt en ingesteld als startpagina (**Instellingen → Lezen**)
- [ ] Navigatiemenu klopt — alle paginalinks werken
- [ ] Logo is geüpload
- [ ] Kleurenpalet en lettertypen zijn ingesteld
- [ ] Ronde hoeken zijn naar wens ingesteld
- [ ] Duurzaamheidsmodus is gekozen
- [ ] Alle pagina's zijn gepubliceerd (niet op concept of privé)
- [ ] Contactpagina heeft een werkend formulier (plugin nodig)
- [ ] Afbeeldingen zijn geoptimaliseerd (niet groter dan nodig)

### SEO en zichtbaarheid

- [ ] Ga naar **Instellingen → Lezen** → zorg dat **"Zoekmachines verzoeken deze site niet te indexeren"** uitstaat
- [ ] Stel een SEO-plugin in (bijv. Yoast SEO of Rank Math) voor meta-titels en beschrijvingen
- [ ] Voeg een **sitemap.xml** toe via de SEO-plugin
- [ ] Stel Google Analytics of een privacy-vriendelijk alternatief (bijv. Fathom, Plausible) in

### Technisch

- [ ] Controleer of je site werkt op mobiel (gebruik Chrome → DevTools → Responsive modus)
- [ ] Test alle knoppen en links
- [ ] Zorg voor een SSL-certificaat (je hostingprovider regelt dit meestal automatisch — de site moet op `https://` draaien)
- [ ] Stel een back-upoplossing in (bijv. UpdraftPlus)

### Publiceer

Als je op een lokale omgeving hebt gewerkt, upload je de site naar je live hosting. Gebruik hiervoor:
- **Duplicator** of **All-in-One WP Migration** (plugins) voor een snelle verhuizing
- Of de handmatige manier: exporteer via **Extra → Exporteren** en importeer via **Extra → Importeren** op de live server

---

## 19. Updates ontvangen

The Sustainable Theme controleert automatisch of er nieuwe versies beschikbaar zijn via GitHub. Als er een update klaarstaat, zie je dit onder **Weergave → Thema's** — net zoals bij reguliere WordPress-thema's.

Je hoeft niets in te stellen. De updatecontrole werkt automatisch op de achtergrond.

**Wil je handmatig controleren op updates?**

1. Ga naar **Weergave → Thema's**
2. Klik op **The Sustainable Theme**
3. Als er een nieuwe versie is, staat er een knop **Update beschikbaar**

---

## Veelgestelde vragen

**Kan ik mijn eigen lettertype van een andere bron gebruiken?**  
Ja. Je kunt een lettertype als bestand uploaden via **Weergave → Editor → Lettertypen → Uploaden**. Zorg voor een `.woff2`-bestand voor de beste prestaties.

**Kan ik patterns aanpassen en hergebruiken?**  
Ja. Pas een pattern aan op een pagina, selecteer alle blokken erin, en kies **+ Patroon aanmaken** in de blokwerkbalk. Je slaat het dan op als jouw eigen pattern.

**Werkt dit thema met WooCommerce?**  
De kernfuncties van WooCommerce werken, maar het thema bevat geen WooCommerce-specifieke templates of patronen. Gebruik Base Mode als je een webshop runt.

**Ik zie de Sustainable Theme-menuoptie niet in mijn dashboard.**  
Zorg dat het thema actief is. Ga naar **Weergave → Thema's** en controleer of The Sustainable Theme is geactiveerd.

**Mijn afbeeldingen zijn wazig na uploaden.**  
WordPress genereert automatisch meerdere formaten van elke afbeelding. Upload afbeeldingen altijd in het grootste formaat dat je nodig hebt (minimaal 1600px breed voor cover-afbeeldingen) en laat WordPress de rest doen.

**Hoe verwijder ik een sectie uit een pattern?**  
Klik op de sectie → selecteer het buitenste Group-blok (gebruik de blokbreadcrumb onderaan de editor om het juiste blok te selecteren) → druk op Delete.

---

## Hulp en support

- **Website:** [pixeltoplanet.earth](https://pixeltoplanet.earth)
- **Documentatie:** in de `docs/`-map van het thema of op de GitHub-repository
- **GitHub:** [github.com/pixeltoplanet/sustainable-theme](https://github.com/pixeltoplanet/sustainable-theme)

---

*The Sustainable Theme — gemaakt door Pixel to Planet · Making WordPress more sustainable, one site at a time.*
