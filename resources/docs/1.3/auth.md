# Autorization

---

-   [Introduction](#section-1)
-   [Configuration](#section-2)

<a name="section-1"></a>

## Introduction

All requests to PAL APIs mus be made with an authorization header.

<a name="section-2"></a>

## Configuration

The authorization header of your request must be of type Bearer, with the API keys provided on pal user <a href="https://dashboard.pals.africa/dashboards/api" target="_blank">Dashboard</a>

You need both a public and private keys to be authenticated and make API calls

<div class="code-toolbar"><pre class="  language-php" style="position: relative;">
<code class="  language-php">secret_key<span class="token punctuation">:</span>public_key</code>
<div class="open_grepper_editor" title="Edit &amp; Save To Grepper"></div></pre><div class="toolbar"><div class="toolbar-item"><a>Copy</a></div></div></div>
