# Bank Transactions

-   [Introduction](#section-1)
-   [Request Transactions List](#section-2)
-   [Request Transaction Details](#section-3)
-   [Response Transactions List](#section-4)
-   [Response Transaction Details](#section-5)

<a name="section-1"></a>

## Introduction

You can use these API calls to get your processed bank transactions, as well as check the status of a bank disbursement

<a name="section-2"></a>

## Requests
<h2>Get Business Transactions/Disbursements List</h2>

<h3>Endpoint Live</h3>

<table>
    <thead>
        <tr>
            <th style="text-align: left">Method</th>
            <th style="text-align: left">URI</th>
            <th style="text-align: left">Headers</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left">GET</td>
            <td style="text-align: left"><code>https://api.pals.africa/api/getbusinessbanktransactions/:user_id</code></td>
            <td style="text-align: left">Authorization: Bearer api_keys</td>
        </tr>
    </tbody>
</table>

<h3>Endpoint Test</h3>

<table>
    <thead>
        <tr>
            <th style="text-align: left">Method</th>
            <th style="text-align: left">URI</th>
            <th style="text-align: left">Headers</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left">GET</td>
            <td style="text-align: left"><code>https://api-test.pals.africa/api/getbusinessbanktransactions/:user_id</code></td>
            <td style="text-align: left">Authorization: Bearer api_keys</td>
        </tr>
    </tbody>
</table>

<h3>URL Params</h3>

<h3>URL Params</h3>
<div class="code-toolbar">
   <ul>
       <pre class="language-php" style="position: relative"><code class="  language-php">user_id</code></pre>
   </ul>
</div>

<h3>Data Params</h3>
<div class="code-toolbar">
    <pre class="language-php" style="position: relative"><code class="  language-php">None</code></pre>
</div>

<a name="section-3"></a>
<h2>Verify Business Transaction/Disbursement</h2>

<h3>Endpoint Live</h3>

<table>
    <thead>
        <tr>
            <th style="text-align: left">Method</th>
            <th style="text-align: left">URI</th>
            <th style="text-align: left">Headers</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left">GET</td>
            <td style="text-align: left"><code>https://api.pals.africa/api/checkbanktransferstatus/:user_id/:transfer_id</code></td>
            <td style="text-align: left">Authorization: Bearer api_keys</td>
        </tr>
    </tbody>
</table>

<h3>Endpoint Test</h3>

<table>
    <thead>
        <tr>
            <th style="text-align: left">Method</th>
            <th style="text-align: left">URI</th>
            <th style="text-align: left">Headers</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left">GET</td>
            <td style="text-align: left"><code>https://api-test.pals.africa/api/checkbanktransferstatus/:user_id/:transfer_id</code></td>
            <td style="text-align: left">Authorization: Bearer api_keys</td>
        </tr>
    </tbody>
</table>

<h3>URL Params</h3>
<div class="code-toolbar">
   <ul>
       <pre class="language-php" style="position: relative"><code class="  language-php">user_id</code></pre>
       <pre class="language-php" style="position: relative"><code class="  language-php">transfer_id</code></pre>
   </ul>
</div>

<h3>Data Params</h3>
<div class="code-toolbar">
    <pre class="language-php" style="position: relative"><code class="  language-php">None</code></pre>
</div>

<blockquote class="alert is-info"><p><div class="icon"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span></div> 
<p>The <code>user_id</code> is the ID generated when you register and add a business and is available on the <a href="https://dashboard.pals.africa/dashboards/api" target="_blank">Dashboard</a></p>
 <p>The <code>reference</code> is the unique key generated for each transaction/disbursement</p>
</blockquote>


<a name="section-4"></a>

## Response
<h3>Get Business Transactions/Disbursements Response</h3>
<blockquote class="alert is-success"><p><div class="icon"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.625 25.625"><g transform="translate(-0.188 -0.188)"><path d="M13,.188A12.813,12.813,0,1,0,25.813,13,12.815,12.815,0,0,0,13,.188Zm6.734,8.848L12.863,19.168a1.076,1.076,0,0,1-.848.5,1.378,1.378,0,0,1-.9-.4L7.086,15.238a.707.707,0,0,1,0-1l1-1a.7.7,0,0,1,.992,0L11.7,15.867l5.7-8.414a.712.712,0,0,1,.98-.187l1.168.793A.706.706,0,0,1,19.734,9.035Z"></path></g></svg></span></div><p>Success Response</p> </p></blockquote>

<p>Code <code>200</code></p>

<p>Content</p>
<div class="code-toolbar"><pre class="  language-json" style="position: relative;"><code class="  language-json">
<span class="token punctuation">{</span>
<span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">true</span><span class="token punctuation">,
<span class="token property">"message"</span> <span class="token operator">:</span> <span class="token string">"Business User transactions list retrieved successfully"</span><span class="token punctuation">,</span>
<span class="token property">"data"</span>    <span class="token operator">:</span><span class="token punctuation">[</span><span class="token punctuation">{</span>
    <span class="token property">"id"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"transfer_id"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"beneficiary_name"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"account_number"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"bank_code"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"full_name"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"created_at"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"bank_code"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"amount"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"currency"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"charges"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"reference"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"narration"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"complete_message"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"requires_approval"</span> <span class="token operator">:</span> <span class="token string">0|1</span><span class="token punctuation">,</span>
    <span class="token property">"is_approved"</span> <span class="token operator">:</span> <span class="token string">"0|1"</span><span class="token punctuation">,</span>
    <span class="token property">"bank_name"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token punctuation">}</span><span class="token punctuation">]</span>
  <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code><div class="open_grepper_editor" title="Edit &amp; Save To Grepper"></div></pre><div class="toolbar"><div class="toolbar-item"><a>Copy</a></div></div></div>

<blockquote class="alert is-danger"><p><div class="icon"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M25,0C15.625,0,8,5.977,8,13.313a10.656,10.656,0,0,0,1.5,5.781,10.92,10.92,0,0,1,1.438,4.969A10.908,10.908,0,0,0,13,18.406a25.849,25.849,0,0,0-.969-6.125,1.009,1.009,0,1,1,1.938-.562A27.747,27.747,0,0,1,15,18.406c0,2.887-1.4,5.184-2.531,7.031-.395.645-.766,1.227-1.031,1.781.609.895,1.863,1.25,3.875,1.563,2.086.324,4.688.7,4.688,3.406,0,.547,1.992,1.906,5,1.906s5-1.359,5-1.906c0-2.766,2.613-3.152,4.719-3.469,1.984-.3,3.238-.625,3.844-1.5-.27-.551-.637-1.137-1.031-1.781C36.4,23.59,35,21.293,35,18.406a27.747,27.747,0,0,1,1.031-6.687,1.009,1.009,0,0,1,1.938.563A25.849,25.849,0,0,0,37,18.406a11.028,11.028,0,0,0,2.063,5.688A10.841,10.841,0,0,1,40.5,19.219,10.937,10.937,0,0,0,42,13.313C42,5.977,34.375,0,25,0ZM19.813,18C21.711,18,23,19.988,23,21.688A4.084,4.084,0,0,1,18.594,26C17.492,26,16,24.988,16,21.688A3.655,3.655,0,0,1,19.813,18Zm10.375,0A3.655,3.655,0,0,1,34,21.688C34,24.988,32.508,26,31.406,26A4.084,4.084,0,0,1,27,21.688C27,19.988,28.289,18,30.188,18ZM4.563,21.031a2.914,2.914,0,0,0-2.719,1.625,4.086,4.086,0,0,0-.312,3.031A3.419,3.419,0,0,0,0,28.906a3.607,3.607,0,0,0,3.313,3.688,3.8,3.8,0,0,0,1.813-.437.926.926,0,0,1,.406-.125,3.079,3.079,0,0,1,1.094.406l7.281,2.969a31.556,31.556,0,0,0-.5-4.937,5.507,5.507,0,0,1-3.625-2.125,1.948,1.948,0,0,1-.156-1.969c.023-.047.07-.109.094-.156-.328-.125-.652-.262-.969-.375-.637-.23-.723-.469-.844-1.344a3.575,3.575,0,0,0-2.219-3.219A3.1,3.1,0,0,0,4.563,21.031Zm40.875,0a3.277,3.277,0,0,0-1.156.25,3.63,3.63,0,0,0-2.219,3.25c-.121.875-.16,1.1-.844,1.344-.3.121-.605.246-.906.375.016.031.047.063.063.094a2.035,2.035,0,0,1-.156,2.031,5.686,5.686,0,0,1-3.781,2.063,36.6,36.6,0,0,0-.375,4.781l7.375-2.812a2.843,2.843,0,0,1,1.031-.375,1.186,1.186,0,0,1,.406.156,3.873,3.873,0,0,0,1.813.406A3.61,3.61,0,0,0,50,28.906a3.413,3.413,0,0,0-1.531-3.156,4.136,4.136,0,0,0-.312-3.094A2.917,2.917,0,0,0,45.438,21.031ZM24.906,26C26.105,26,28,30.211,28,30.813a1.064,1.064,0,0,1-1.187,1.094c-.8,0-1.707-2.207-1.906-2.906h-.094c-.7,2-1.32,3-1.719,3-.8,0-1.094-.508-1.094-1.406C22,28.992,23.707,26,24.906,26Zm-9.375,4.813a59.9,59.9,0,0,1,.438,6.219c.027.785.059,1.641.094,2C16.848,40,21.578,44,25,44c3.438,0,8.215-4.02,8.938-5.031.027-.293.074-1.234.094-2.062.059-2.32.129-4.512.344-6.094a9.289,9.289,0,0,0-1.469.344c-.129.789-.223,1.5-.312,2.156C31.965,37.941,31.41,40,25,40c-6.5,0-7.055-2.055-7.656-6.719-.082-.637-.164-1.332-.281-2.094A10.3,10.3,0,0,0,15.531,30.813Zm4.031,3.813c.316,1.953.75,2.844,2.438,3.188V35.719A8.058,8.058,0,0,1,19.563,34.625Zm10.813.063A8.182,8.182,0,0,1,28,35.719v2.063C29.609,37.434,30.051,36.586,30.375,34.688ZM24,36.063V38c.313.008.641,0,1,0s.688.008,1,0V36.063c-.328.027-.66.031-1,.031S24.328,36.09,24,36.063Zm12,1.375a9.337,9.337,0,0,1-.156,2.188,9.893,9.893,0,0,1-3.031,3.063,63.421,63.421,0,0,1,5.688,3,4.654,4.654,0,0,1,.375,1.031c.363,1.23.965,3.281,3.313,3.281A3.3,3.3,0,0,0,45,48.75a4.55,4.55,0,0,0,.563-3.469c.059-.023.1-.07.156-.094a3.41,3.41,0,0,0,2.563-2.656,3.176,3.176,0,0,0-.437-2.5,2.955,2.955,0,0,0-2.219-1.219,3.549,3.549,0,0,0-2.812,1.156c-.187.168-.473.465-.687.438C40.93,39.855,36.582,37.723,36,37.438Zm-22.031.094c-1.348.633-5.039,2.363-6.156,2.844-.02.008-.074.055-.094.063A2.666,2.666,0,0,1,7.156,40a3.45,3.45,0,0,0-2.875-1.187,2.9,2.9,0,0,0-2.062,1.063,3.55,3.55,0,0,0-.625,2.563.879.879,0,0,0,.031.094,3.553,3.553,0,0,0,2.531,2.625c.063.027.125.07.188.094a4.665,4.665,0,0,0,.594,3.5A3.207,3.207,0,0,0,7.688,50c2.348,0,2.98-2.051,3.344-3.281a8.166,8.166,0,0,1,.313-1c1.219-.812,4.777-2.551,5.813-3.062a10.915,10.915,0,0,1-3-2.937A11.042,11.042,0,0,1,13.969,37.531Z"></path></svg></span></div><p>Error Response</p></p></blockquote>

<p>Code <code>404</code></p>
<p>reason<code> User does not exist</code></p>


<p>Code <code>403</code></p>
<p>reason<code> Invalid api keys</code></p>

<p>Content</p>
<div class="code-toolbar"><pre class="  language-json" style="position: relative;"><code class="  language-json">
<span class="token punctuation">{</span>
<span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">false</span><span class="token punctuation">,
<span class="token property">"message"</span> <span class="token operator">:</span> <span class="token string">"{reason}"</span><span class="token punctuation">
<span class="token punctuation">}</span></code><div class="open_grepper_editor" title="Edit &amp; Save To Grepper"></div></pre><div class="toolbar"><div class="toolbar-item"><a>Copy</a></div></div></div>

<a name="section-5"></a>

<h3>Verify Business Transaction/Disbursement Response</h3>
<blockquote class="alert is-success"><p><div class="icon"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.625 25.625"><g transform="translate(-0.188 -0.188)"><path d="M13,.188A12.813,12.813,0,1,0,25.813,13,12.815,12.815,0,0,0,13,.188Zm6.734,8.848L12.863,19.168a1.076,1.076,0,0,1-.848.5,1.378,1.378,0,0,1-.9-.4L7.086,15.238a.707.707,0,0,1,0-1l1-1a.7.7,0,0,1,.992,0L11.7,15.867l5.7-8.414a.712.712,0,0,1,.98-.187l1.168.793A.706.706,0,0,1,19.734,9.035Z"></path></g></svg></span></div><p>Success Response</p> </p></blockquote>

<p>Code <code>200</code></p>

<p>Content</p>
<div class="code-toolbar"><pre class="  language-json" style="position: relative;"><code class="  language-json">
<span class="token punctuation">{</span>
<span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">true</span><span class="token punctuation">,
<span class="token property">"message"</span> <span class="token operator">:</span> <span class="token string">"Business User transaction details retrieved successfully"</span><span class="token punctuation">,</span>
<span class="token property">"data"</span>    <span class="token operator">:</span><span class="token punctuation">{</span>
    <span class="token property">"id"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"transfer_id"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"beneficiary_name"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"account_number"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"bank_code"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"full_name"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"created_at"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"bank_code"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"amount"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"currency"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"charges"</span> <span class="token operator">:</span> <span class="token string">number</span><span class="token punctuation">,</span>
    <span class="token property">"reference"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"narration"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"complete_message"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token property">"requires_approval"</span> <span class="token operator">:</span> <span class="token string">0|1</span><span class="token punctuation">,</span>
    <span class="token property">"is_approved"</span> <span class="token operator">:</span> <span class="token string">"0|1"</span><span class="token punctuation">,</span>
    <span class="token property">"bank_name"</span> <span class="token operator">:</span> <span class="token string">string</span><span class="token punctuation">,</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code><div class="open_grepper_editor" title="Edit &amp; Save To Grepper"></div></pre><div class="toolbar"><div class="toolbar-item"><a>Copy</a></div></div></div>

<blockquote class="alert is-danger"><p><div class="icon"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M25,0C15.625,0,8,5.977,8,13.313a10.656,10.656,0,0,0,1.5,5.781,10.92,10.92,0,0,1,1.438,4.969A10.908,10.908,0,0,0,13,18.406a25.849,25.849,0,0,0-.969-6.125,1.009,1.009,0,1,1,1.938-.562A27.747,27.747,0,0,1,15,18.406c0,2.887-1.4,5.184-2.531,7.031-.395.645-.766,1.227-1.031,1.781.609.895,1.863,1.25,3.875,1.563,2.086.324,4.688.7,4.688,3.406,0,.547,1.992,1.906,5,1.906s5-1.359,5-1.906c0-2.766,2.613-3.152,4.719-3.469,1.984-.3,3.238-.625,3.844-1.5-.27-.551-.637-1.137-1.031-1.781C36.4,23.59,35,21.293,35,18.406a27.747,27.747,0,0,1,1.031-6.687,1.009,1.009,0,0,1,1.938.563A25.849,25.849,0,0,0,37,18.406a11.028,11.028,0,0,0,2.063,5.688A10.841,10.841,0,0,1,40.5,19.219,10.937,10.937,0,0,0,42,13.313C42,5.977,34.375,0,25,0ZM19.813,18C21.711,18,23,19.988,23,21.688A4.084,4.084,0,0,1,18.594,26C17.492,26,16,24.988,16,21.688A3.655,3.655,0,0,1,19.813,18Zm10.375,0A3.655,3.655,0,0,1,34,21.688C34,24.988,32.508,26,31.406,26A4.084,4.084,0,0,1,27,21.688C27,19.988,28.289,18,30.188,18ZM4.563,21.031a2.914,2.914,0,0,0-2.719,1.625,4.086,4.086,0,0,0-.312,3.031A3.419,3.419,0,0,0,0,28.906a3.607,3.607,0,0,0,3.313,3.688,3.8,3.8,0,0,0,1.813-.437.926.926,0,0,1,.406-.125,3.079,3.079,0,0,1,1.094.406l7.281,2.969a31.556,31.556,0,0,0-.5-4.937,5.507,5.507,0,0,1-3.625-2.125,1.948,1.948,0,0,1-.156-1.969c.023-.047.07-.109.094-.156-.328-.125-.652-.262-.969-.375-.637-.23-.723-.469-.844-1.344a3.575,3.575,0,0,0-2.219-3.219A3.1,3.1,0,0,0,4.563,21.031Zm40.875,0a3.277,3.277,0,0,0-1.156.25,3.63,3.63,0,0,0-2.219,3.25c-.121.875-.16,1.1-.844,1.344-.3.121-.605.246-.906.375.016.031.047.063.063.094a2.035,2.035,0,0,1-.156,2.031,5.686,5.686,0,0,1-3.781,2.063,36.6,36.6,0,0,0-.375,4.781l7.375-2.812a2.843,2.843,0,0,1,1.031-.375,1.186,1.186,0,0,1,.406.156,3.873,3.873,0,0,0,1.813.406A3.61,3.61,0,0,0,50,28.906a3.413,3.413,0,0,0-1.531-3.156,4.136,4.136,0,0,0-.312-3.094A2.917,2.917,0,0,0,45.438,21.031ZM24.906,26C26.105,26,28,30.211,28,30.813a1.064,1.064,0,0,1-1.187,1.094c-.8,0-1.707-2.207-1.906-2.906h-.094c-.7,2-1.32,3-1.719,3-.8,0-1.094-.508-1.094-1.406C22,28.992,23.707,26,24.906,26Zm-9.375,4.813a59.9,59.9,0,0,1,.438,6.219c.027.785.059,1.641.094,2C16.848,40,21.578,44,25,44c3.438,0,8.215-4.02,8.938-5.031.027-.293.074-1.234.094-2.062.059-2.32.129-4.512.344-6.094a9.289,9.289,0,0,0-1.469.344c-.129.789-.223,1.5-.312,2.156C31.965,37.941,31.41,40,25,40c-6.5,0-7.055-2.055-7.656-6.719-.082-.637-.164-1.332-.281-2.094A10.3,10.3,0,0,0,15.531,30.813Zm4.031,3.813c.316,1.953.75,2.844,2.438,3.188V35.719A8.058,8.058,0,0,1,19.563,34.625Zm10.813.063A8.182,8.182,0,0,1,28,35.719v2.063C29.609,37.434,30.051,36.586,30.375,34.688ZM24,36.063V38c.313.008.641,0,1,0s.688.008,1,0V36.063c-.328.027-.66.031-1,.031S24.328,36.09,24,36.063Zm12,1.375a9.337,9.337,0,0,1-.156,2.188,9.893,9.893,0,0,1-3.031,3.063,63.421,63.421,0,0,1,5.688,3,4.654,4.654,0,0,1,.375,1.031c.363,1.23.965,3.281,3.313,3.281A3.3,3.3,0,0,0,45,48.75a4.55,4.55,0,0,0,.563-3.469c.059-.023.1-.07.156-.094a3.41,3.41,0,0,0,2.563-2.656,3.176,3.176,0,0,0-.437-2.5,2.955,2.955,0,0,0-2.219-1.219,3.549,3.549,0,0,0-2.812,1.156c-.187.168-.473.465-.687.438C40.93,39.855,36.582,37.723,36,37.438Zm-22.031.094c-1.348.633-5.039,2.363-6.156,2.844-.02.008-.074.055-.094.063A2.666,2.666,0,0,1,7.156,40a3.45,3.45,0,0,0-2.875-1.187,2.9,2.9,0,0,0-2.062,1.063,3.55,3.55,0,0,0-.625,2.563.879.879,0,0,0,.031.094,3.553,3.553,0,0,0,2.531,2.625c.063.027.125.07.188.094a4.665,4.665,0,0,0,.594,3.5A3.207,3.207,0,0,0,7.688,50c2.348,0,2.98-2.051,3.344-3.281a8.166,8.166,0,0,1,.313-1c1.219-.812,4.777-2.551,5.813-3.062a10.915,10.915,0,0,1-3-2.937A11.042,11.042,0,0,1,13.969,37.531Z"></path></svg></span></div><p>Error Response</p></p></blockquote>

<p>Code <code>404</code></p>
<p>reason<code> User does not exist</code></p>
<p>reason<code> Transaction does not exist</code></p>

<p>Code <code>403</code></p>
<p>reason<code> Invalid api keys</code></p>

<p>Content</p>
<div class="code-toolbar"><pre class="  language-json" style="position: relative;"><code class="  language-json">
<span class="token punctuation">{</span>
<span class="token property">"status"</span> <span class="token operator">:</span> <span class="token string">false</span><span class="token punctuation">,
<span class="token property">"message"</span> <span class="token operator">:</span> <span class="token string">"{reason}"</span><span class="token punctuation">
<span class="token punctuation">}</span></code><div class="open_grepper_editor" title="Edit &amp; Save To Grepper"></div></pre><div class="toolbar"><div class="toolbar-item"><a>Copy</a></div></div></div>
