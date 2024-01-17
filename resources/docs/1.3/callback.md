# Callback

-   [Introduction](#section-1)
-   [Request](#section-2)
<!---   [Response](#section-3)-->

<a name="section-1"></a>

## Introduction

You can set you callback url in the dashboard, under the <code>API</code> section.
The API will send a post request to your callback URL with the parameters specified below.
This callback URL will be used everytime there is an update on the transaction being processed.


## Request
<a name="section-2"></a>

<h3>Endpoint</h3>

<table>
    <thead>
        <tr>
            <th style="text-align: left">Method</th>
            <th style="text-align: left">URI</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left">POST</td>
            <td style="text-align: left"><code>YOUR_CALLBACK_URL</code></td>
        </tr>
    </tbody>
</table>


<h3>Params</h3>
<div class="code-toolbar">
<div class="code-toolbar"><pre class="  language-json" style="position: relative;"><code class="  language-json">
<span class="token punctuation">{</span>
<span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">true</span><span class="token punctuation">,
<span class="token property">"data"</span>    <span class="token operator">:</span><span class="token punctuation">{</span>
    <span class="token property">"id"</span> <span class="token operator">:</span> <span class="token string">"number"</span><span class="token punctuation">,</span>
    <span class="token property">"phone_no"</span> <span class="token operator">:</span> <span class="token string">"string"</span><span class="token punctuation">,</span>
    <span class="token property">"amount"</span> <span class="token operator">:</span> <span class="token string">"string"</span><span class="token punctuation">,</span>
    <span class="token property">"currency"</span> <span class="token operator">:</span> <span class="token string">"string"</span><span class="token punctuation">,</span>
    <span class="token property">"country"</span> <span class="token operator">:</span> <span class="token string">"string"</span><span class="token punctuation">,</span>
    <span class="token property">"operator"</span> <span class="token operator">:</span> <span class="token string">"string"</span><span class="token punctuation">,</span>
    <span class="token property">"user_id"</span> <span class="token operator">:</span> <span class="token string">"string"</span><span class="token punctuation">,</span>
    <span class="token property">"reference"</span> <span class="token operator">:</span> <span class="token string">"string"</span>
    <span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">"string"</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code><div class="open_grepper_editor" title="Edit &amp; Save To Grepper"></div></pre><div class="toolbar"><div class="toolbar-item"><a>Copy</a></div></div></div>
   </div>
<blockquote class="alert is-info"><p><div class="icon"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span></div> 
<p>The <code>user_id</code> is the ID generated when you register and add a business and is available on the <a href="https://dashboard.pals.africa/dashboards/api" target="_blank">Dashboard</a></p>
 <p>The <code>module_id</code> is available on the <a href="https://api.pals.africa/docs/1.0/modules#section-2" target="_blank">Get Modules data API call</a> and depends on the currency, country and operator </p>
 <p>The <code>status</code> will inform you on where your transaction stands</p>
</blockquote>

<!--<a name="section-3"></a>-->
