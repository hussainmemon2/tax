@extends('layouts.app')

@section('page-title', 'Upload Documents')

@section('content')
<style>
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        flex-wrap: wrap; gap: 12px; margin-bottom: 28px;
    }
    .page-header .eyebrow {
        font-size: .7rem; font-weight: 600; letter-spacing: .14em;
        text-transform: uppercase; color: var(--gold); margin-bottom: 4px;
    }
    .page-header h2 {
        font-family: 'Playfair Display', serif; font-size: 1.55rem;
        font-weight: 700; color: var(--text-main); margin: 0;
    }
    .page-header p { font-size: .84rem; color: var(--text-sub); margin: 3px 0 0; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px;
        border-radius: 10px; border: 1.5px solid var(--border); background: #fff;
        font-size: .84rem; font-weight: 600; color: var(--text-main);
        text-decoration: none; transition: .2s; font-family: 'DM Sans', sans-serif; white-space: nowrap;
    }
    .btn-back:hover { border-color: var(--navy); color: var(--navy); }

    /* ── Layout ── */
    .upload-layout {
        display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start;
    }
    @media (max-width: 960px) { .upload-layout { grid-template-columns: 1fr; } }

    /* ── Form card ── */
    .form-card {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06); margin-bottom: 20px;
    }
    .form-card-header {
        padding: 17px 24px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 11px;
        background: linear-gradient(90deg, #F8F9FC, #fff);
    }
    .fch-icon {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem; flex-shrink: 0;
    }
    .fch-gold { background: var(--gold-pale); border: 1px solid rgba(201,168,76,.2); color: var(--gold); }
    .fch-blue { background: rgba(37,99,235,.08); border: 1px solid rgba(37,99,235,.15); color: #2563EB; }
    .fch-title { font-family: 'Playfair Display', serif; font-size: .93rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .fch-sub   { font-size: .73rem; color: var(--text-sub); margin: 2px 0 0; }
    .form-card-body { padding: 22px 24px; }

    /* ── Fields ── */
    .field-group { margin-bottom: 18px; }
    .field-group:last-child { margin-bottom: 0; }
    .field-group label {
        display: block; font-size: .73rem; font-weight: 700;
        letter-spacing: .07em; text-transform: uppercase; color: #3D4F72; margin-bottom: 7px;
    }
    .field-group label .req { color: var(--gold); margin-left: 2px; }
    .field-wrap { position: relative; }
    .field-wrap .f-icon {
        position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
        color: #9AAACB; font-size: .9rem; pointer-events: none; z-index: 5;
    }

    /* ── Service loader ── */
    .service-loading-ring {
        display: none;
        position: absolute; right: 38px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; border-radius: 50%;
        border: 2px solid var(--border); border-top-color: var(--gold);
        animation: svcSpin .65s linear infinite; z-index: 6; pointer-events: none;
    }
    @keyframes svcSpin { to { transform: translateY(-50%) rotate(360deg); } }

    .service-hint {
        display: flex; align-items: center; gap: 5px;
        font-size: .72rem; color: var(--text-sub); margin-top: 6px; min-height: 18px;
    }
    .service-hint i { font-size: .72rem; }
    .service-hint.loading { color: var(--gold); }
    .service-hint.loaded  { color: #059669; }
    .service-hint.error   { color: #E05252; }
    .service-hint.empty   { color: #E05252; }

    /* ── Select2 ── */
    .select2-container .select2-selection--single {
        height: 44px !important; border: 1.5px solid var(--border) !important;
        border-radius: 9px !important; padding: 0 14px 0 38px !important;
        font-family: 'DM Sans', sans-serif !important; font-size: .88rem !important;
        background: #fff !important; display: flex !important; align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 0 !important; line-height: 44px !important; color: var(--text-main) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder { color: #B0BEDB !important; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 44px !important; right: 12px !important; }
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--gold) !important; box-shadow: 0 0 0 3px rgba(201,168,76,.11) !important; outline: none !important;
    }
    .select2-dropdown {
        border: 1.5px solid var(--border) !important; border-radius: 10px !important;
        box-shadow: 0 10px 36px rgba(15,31,61,.14) !important;
        font-family: 'DM Sans', sans-serif !important; font-size: .88rem !important; z-index: 99999 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--gold-pale) !important; color: var(--text-main) !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] { background: #F0F4FF !important; }
    .select2-search--dropdown .select2-search__field {
        border: 1.5px solid var(--border) !important; border-radius: 8px !important;
        padding: 8px 12px !important; font-family: 'DM Sans', sans-serif !important;
    }
    .select2-search--dropdown .select2-search__field:focus { border-color: var(--gold) !important; outline: none !important; }
    .select2-container--disabled .select2-selection--single {
        background: #F4F6FB !important; cursor: not-allowed !important; opacity: .7;
    }

    /* ══ DOCUMENT AREA ══ */
    .doc-area-card {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06);
    }
    .doc-area-header {
        padding: 17px 24px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        background: linear-gradient(90deg, #F8F9FC, #fff); flex-wrap: wrap;
    }
    .doc-area-title {
        display: flex; align-items: center; gap: 10px;
    }
    .doc-area-title-text { font-family: 'Playfair Display', serif; font-size: .93rem; font-weight: 700; color: var(--text-main); }
    .doc-area-title-sub  { font-size: .73rem; color: var(--text-sub); margin-top: 1px; }

    .btn-add-doc {
        display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px;
        border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 600;
        cursor: pointer; border: 1.5px solid rgba(37,99,235,.22);
        background: rgba(37,99,235,.07); color: #2563EB; transition: .18s;
    }
    .btn-add-doc:hover { background: rgba(37,99,235,.14); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(37,99,235,.12); }

    .doc-area-body { padding: 20px 24px 24px; }

    /* Drop zone */
    .doc-dropzone {
        border: 2px dashed var(--border); border-radius: 12px;
        padding: 40px 20px; text-align: center; cursor: pointer;
        transition: border-color .2s, background .2s; background: #FAFBFD;
    }
    .doc-dropzone:hover { border-color: #2563EB; background: rgba(37,99,235,.03); }
    .doc-dropzone .dz-icon { font-size: 2.2rem; color: #C8D2E8; display: block; margin-bottom: 10px; }
    .doc-dropzone .dz-title { font-size: .88rem; font-weight: 600; color: var(--text-sub); margin-bottom: 4px; }
    .doc-dropzone .dz-sub   { font-size: .75rem; color: #B0BEDB; }

    /* Card grid */
    .doc-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 12px;
    }

    /* Each attachment card */
    .doc-attach-card {
        background: #fff; border: 1.5px solid var(--border); border-radius: 12px;
        padding: 14px; position: relative; animation: cardIn .22s ease both;
        transition: border-color .2s, box-shadow .2s; display: flex; flex-direction: column; gap: 10px;
    }
    .doc-attach-card:hover { border-color: rgba(37,99,235,.28); box-shadow: 0 4px 18px rgba(37,99,235,.08); }

    @keyframes cardIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Top row: icon + file meta + remove */
    .doc-card-top { display: flex; align-items: flex-start; gap: 10px; }
    .doc-file-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1.05rem;
    }
    .doc-icon-pdf   { background: rgba(220,38,38,.1);  color: #DC2626; border: 1px solid rgba(220,38,38,.18); }
    .doc-icon-image { background: rgba(124,58,237,.1); color: #7C3AED; border: 1px solid rgba(124,58,237,.18); }
    .doc-icon-excel { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.18); }
    .doc-icon-word  { background: rgba(37,99,235,.1);  color: #2563EB; border: 1px solid rgba(37,99,235,.18); }
    .doc-icon-txt   { background: rgba(100,116,139,.1);color: #475569; border: 1px solid rgba(100,116,139,.18); }
    .doc-icon-other { background: rgba(201,168,76,.1); color: var(--gold); border: 1px solid rgba(201,168,76,.2); }

    .doc-file-meta { flex: 1; min-width: 0; }
    .doc-actual-name {
        font-size: .78rem; color: var(--text-sub); white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis; line-height: 1.3; margin-bottom: 2px;
    }
    .doc-filesize { font-size: .71rem; color: #B0BEDB; }

    .doc-remove-btn {
        width: 26px; height: 26px; border-radius: 7px; flex-shrink: 0;
        border: 1.5px solid rgba(224,82,82,.2); background: rgba(224,82,82,.06);
        color: #E05252; display: flex; align-items: center; justify-content: center;
        font-size: .72rem; cursor: pointer; transition: .15s;
    }
    .doc-remove-btn:hover { background: rgba(224,82,82,.18); border-color: rgba(224,82,82,.4); }

    /* Divider */
    .doc-divider { height: 1px; background: var(--border); margin: 0 -14px; }

    /* Card inner fields */
    .doc-field { display: flex; flex-direction: column; gap: 5px; }
    .doc-field label {
        font-size: .67rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: var(--text-sub);
        display: flex; align-items: center; gap: 5px;
    }
    .doc-field label i { color: var(--gold); font-size: .72rem; }
    .doc-field input {
        width: 100%; padding: 8px 11px; border: 1.5px solid var(--border); border-radius: 8px;
        font-family: 'DM Sans', sans-serif; font-size: .83rem; color: var(--text-main);
        background: #F8F9FC; outline: none; transition: border-color .2s, box-shadow .2s;
    }
    .doc-field input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.1); background: #fff; }
    .doc-field.name-field input { font-weight: 600; background: #fff; border-color: rgba(201,168,76,.25); }
    .doc-hidden-file { display: none; }

    /* ── Sidebar summary card ── */
    .summary-card {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        overflow: hidden; box-shadow: 0 4px 24px rgba(15,31,61,.06);
        position: sticky; top: calc(var(--topbar-h, 70px) + 20px);
    }
    .summary-card-header {
        padding: 16px 20px; border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        display: flex; align-items: center; gap: 10px;
    }
    .s-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: rgba(201,168,76,.2); border: 1px solid rgba(201,168,76,.3);
        display: flex; align-items: center; justify-content: center; color: var(--gold-lt); font-size: .88rem;
    }
    .s-title { font-family: 'Playfair Display', serif; font-size: .95rem; font-weight: 700; color: #fff; }
    .s-sub   { font-size: .72rem; color: rgba(255,255,255,.45); margin-top: 1px; }
    .summary-body { padding: 20px; }

    /* Doc count stat */
    .doc-stat {
        text-align: center; padding: 18px 12px;
        background: #F8F9FC; border: 1px solid var(--border); border-radius: 10px;
        margin-bottom: 16px;
    }
    .doc-stat-num { font-size: 2rem; font-weight: 800; color: #2563EB; line-height: 1; }
    .doc-stat-lbl { font-size: .67rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--text-sub); margin-top: 4px; }

    /* Allowed types list */
    .allowed-types {
        border: 1px solid var(--border); border-radius: 9px; overflow: hidden; margin-bottom: 16px;
    }
    .allowed-types-hd {
        padding: 8px 14px; background: #F8F9FC; border-bottom: 1px solid var(--border);
        font-size: .67rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: #5C6D8A;
    }
    .allowed-types-body { padding: 12px 14px; display: flex; flex-wrap: wrap; gap: 6px; }
    .type-chip {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 50px; font-size: .72rem; font-weight: 600;
        background: rgba(37,99,235,.06); color: #2563EB; border: 1px solid rgba(37,99,235,.15);
    }

    .btn-submit {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 13px; border-radius: 10px; border: none;
        background: linear-gradient(135deg, var(--navy-mid), var(--navy));
        color: #fff; font-family: 'DM Sans', sans-serif; font-size: .92rem; font-weight: 700;
        cursor: pointer; transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 16px rgba(11,27,53,.22); position: relative; overflow: hidden;
    }
    .btn-submit::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(201,168,76,.12) 0%, transparent 60%); }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(11,27,53,.3); }
    .btn-submit:disabled { opacity: .55; cursor: not-allowed; transform: none; }

    /* Validation */
    .alert-validation {
        background: rgba(224,82,82,.06); border: 1.5px solid rgba(224,82,82,.2);
        border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;
        font-size: .83rem; color: #C0392B;
    }
    .alert-validation ul { margin: 6px 0 0 16px; padding: 0; }
    .alert-validation li { margin-bottom: 3px; }
</style>

<!-- ── Page Header ── -->
<div class="page-header">
    <div>
        <div class="eyebrow">Documents</div>
        <h2>Upload Documents</h2>
        <p>Attach files to a client service record</p>
    </div>
    <a href="{{ route('documents.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to Documents
    </a>
</div>

@if($errors->any())
    <div class="alert-validation">
        <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Please fix the following errors:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
    @csrf

    <div class="upload-layout">

        <!-- ════ LEFT ════ -->
        <div>

            <!-- Client & Service -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="fch-icon fch-gold"><i class="bi bi-person-check-fill"></i></div>
                    <div>
                        <div class="fch-title">Assignment</div>
                        <div class="fch-sub">Link these documents to a client service</div>
                    </div>
                </div>
                <div class="form-card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="field-group" style="margin-bottom:0;">
                                <label>Client <span class="req">*</span></label>
                                <div class="field-wrap">
                                    <i class="bi bi-person f-icon"></i>
                                    <select name="client_id" id="client_id" class="select2" required style="width:100%;">
                                        <option value=""></option>
                                        @foreach ($clients as $client)
                                            <option
                                                value="{{ $client->id }}"
                                                data-name="{{ $client->full_name }}"
                                                data-cnic="{{ $client->cnic }}"
                                                {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                {{ $client->full_name }} {{ $client->cnic }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="field-group" style="margin-bottom:0;">
                                <label>Service <span class="req">*</span></label>
                                <div class="field-wrap service-field-wrap">
                                    <i class="bi bi-briefcase f-icon"></i>
                                    <span class="service-loading-ring" id="serviceLoadingRing"></span>
                                    <select name="service_id" id="service_id" class="select2" required style="width:100%;" disabled>
                                        <option value="">Select client first…</option>
                                    </select>
                                </div>
                                <div class="service-hint" id="serviceHint">
                                    <i class="bi bi-info-circle"></i>
                                    <span id="serviceHintText">Choose a client to load available services</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="doc-area-card">
                <div class="doc-area-header">
                    <div class="doc-area-title">
                        <div class="fch-icon fch-blue" style="width:34px;height:34px;font-size:.85rem;">
                            <i class="bi bi-paperclip"></i>
                        </div>
                        <div>
                            <div class="doc-area-title-text">Attached Files</div>
                            <div class="doc-area-title-sub">Click a card field to rename or date each file</div>
                        </div>
                    </div>
                    <button type="button" class="btn-add-doc" id="addDocumentBtn">
                        <i class="bi bi-file-earmark-plus"></i> Add Files
                    </button>
                </div>

                <div class="doc-area-body">

                    <!-- Drop zone — hidden when cards exist -->
                    <div class="doc-dropzone" id="docs-empty" onclick="openFilePicker()">
                        <i class="bi bi-cloud-arrow-up dz-icon"></i>
                        <div class="dz-title">Click to browse files</div>
                        <div class="dz-sub">PDF, Word, Excel, Images and more</div>
                    </div>

                    <!-- Attachment card grid -->
                    <div class="doc-grid" id="documentsContainer"></div>

                </div>
            </div>

        </div><!-- /left -->

        <!-- ════ RIGHT — Sidebar ════ -->
        <div>
            <div class="summary-card">
                <div class="summary-card-header">
                    <div class="s-icon"><i class="bi bi-paperclip"></i></div>
                    <div>
                        <div class="s-title">Upload Summary</div>
                        <div class="s-sub">Ready to attach</div>
                    </div>
                </div>
                <div class="summary-body">

                    <!-- Live doc count -->
                    <div class="doc-stat">
                        <div class="doc-stat-num" id="docCount">0</div>
                        <div class="doc-stat-lbl">Files Selected</div>
                    </div>

                    <!-- Allowed types -->
                    <div class="allowed-types">
                        <div class="allowed-types-hd">Accepted formats</div>
                        <div class="allowed-types-body">
                            <span class="type-chip"><i class="bi bi-file-earmark-pdf"></i> PDF</span>
                            <span class="type-chip"><i class="bi bi-file-earmark-word"></i> Word</span>
                            <span class="type-chip"><i class="bi bi-file-earmark-excel"></i> Excel</span>
                            <span class="type-chip"><i class="bi bi-file-earmark-image"></i> Images</span>
                            <span class="type-chip"><i class="bi bi-file-earmark-text"></i> TXT</span>
                        </div>
                    </div>

                    <button type="submit" form="uploadForm" class="btn-submit" id="submitBtn" disabled>
                        <i class="bi bi-cloud-upload-fill"></i> Upload Documents
                    </button>

                </div>
            </div>
        </div>

    </div>
</form>

@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
/* ════════════════════════════════
   File type helpers
════════════════════════════════ */
function getFileIcon(filename) {
    const ext = filename.split('.').pop().toLowerCase();
    if (ext === 'pdf')                                          return ['bi-file-earmark-pdf-fill',   'doc-icon-pdf'];
    if (['jpg','jpeg','png','gif','bmp','webp'].includes(ext))  return ['bi-file-earmark-image-fill', 'doc-icon-image'];
    if (['xls','xlsx','csv'].includes(ext))                     return ['bi-file-earmark-excel-fill', 'doc-icon-excel'];
    if (['doc','docx'].includes(ext))                           return ['bi-file-earmark-word-fill',  'doc-icon-word'];
    if (ext === 'txt')                                          return ['bi-file-earmark-text-fill',  'doc-icon-txt'];
    return ['bi-file-earmark-fill', 'doc-icon-other'];
}

function fmtBytes(b) {
    if (b < 1024)    return b + ' B';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
    return (b / 1048576).toFixed(1) + ' MB';
}

function stripExt(f) { return f.replace(/\.[^/.]+$/, ''); }

/* ════════════════════════════════
   Counter + submit state
════════════════════════════════ */
function updateCounts() {
    const n = document.querySelectorAll('#documentsContainer .doc-attach-card').length;
    document.getElementById('docCount').textContent = n;
    document.getElementById('docs-empty').style.display = n === 0 ? 'block' : 'none';
    document.getElementById('submitBtn').disabled = n === 0;
}

/* ════════════════════════════════
   File picker + card builder
════════════════════════════════ */
let docIndex = 0;
const ALLOWED = ['jpg','jpeg','png','gif','bmp','webp','pdf','doc','docx','xls','xlsx','csv','txt'];

function openFilePicker() {
    const inp = document.createElement('input');
    inp.type     = 'file';
    inp.multiple = true;
    inp.accept   = ALLOWED.map(e => '.' + e).join(',');
    inp.onchange = function () { processFiles(Array.from(this.files)); };
    inp.click();
}

function processFiles(files) {
    const container = document.getElementById('documentsContainer');
    const today = new Date().toISOString().split('T')[0];

    files.forEach(file => {
        const ext = file.name.split('.').pop().toLowerCase();
        if (!ALLOWED.includes(ext)) return; // skip unsupported

        docIndex++;
        const idx = docIndex;
        const [iconCls, colorCls] = getFileIcon(file.name);
        const nameDefault = stripExt(file.name);

        // Build card element
        const card = document.createElement('div');
        card.className = 'doc-attach-card';
        card.id = 'doc-card-' + idx;
        card.innerHTML = `
            <!-- top: icon + filename + remove -->
            <div class="doc-card-top">
                <div class="doc-file-icon ${colorCls}">
                    <i class="bi ${iconCls}"></i>
                </div>
                <div class="doc-file-meta">
                    <div class="doc-actual-name" title="${file.name}">${file.name}</div>
                    <div class="doc-filesize">${fmtBytes(file.size)}</div>
                </div>
                <button type="button" class="doc-remove-btn" onclick="removeDoc(${idx})">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="doc-divider"></div>

            <!-- Document name field -->
            <div class="doc-field name-field">
                <label><i class="bi bi-pencil"></i> Document Name</label>
                <input
                    type="text"
                    name="documents[${idx}][document_name]"
                    value="${nameDefault}"
                    maxlength="200"
                    placeholder="Enter a display name…">
            </div>

            <!-- Date field -->
            <div class="doc-field">
                <label><i class="bi bi-calendar3"></i> Document Date</label>
                <input
                    type="date"
                    name="documents[${idx}][document_date]"
                    value="${today}">
            </div>

            <!-- Hidden actual file input (injected via DataTransfer) -->
            <input type="file" class="doc-hidden-file" name="documents[${idx}][file]" id="doc-file-${idx}">
        `;

        container.appendChild(card);

        // Inject file into the hidden input via DataTransfer
        try {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('doc-file-' + idx).files = dt.files;
        } catch (e) {
            console.warn('DataTransfer not supported:', e);
        }
    });

    updateCounts();
}

function removeDoc(idx) {
    const card = document.getElementById('doc-card-' + idx);
    if (card) card.remove();
    updateCounts();
}

/* ════════════════════════════════
   Service hint helper
════════════════════════════════ */
function setServiceHint(state, text) {
    const hint = document.getElementById('serviceHint');
    const span = document.getElementById('serviceHintText');
    const iconMap = {
        idle:    'bi-info-circle',
        loading: 'bi-arrow-repeat',
        loaded:  'bi-check-circle-fill',
        empty:   'bi-exclamation-circle-fill',
        error:   'bi-x-circle-fill',
    };
    hint.className = 'service-hint ' + (state !== 'idle' ? state : '');
    hint.querySelector('i').className = 'bi ' + (iconMap[state] || 'bi-info-circle');
    span.textContent = text;
}

/* ════════════════════════════════
   jQuery: Select2 + service AJAX
════════════════════════════════ */
$(document).ready(function () {

    /* Client Select2 */
    $('#client_id').select2({
        width: '100%',
        dropdownParent: $('body'),
        placeholder: 'Search by name or CNIC…',
        allowClear: true,
        escapeMarkup: m => m,
        templateResult: function (client) {
            if (!client.id) return client.text;
            const name = $(client.element).data('name');
            const cnic = $(client.element).data('cnic');
            return `<div><div style="font-weight:600;">${name}</div>${cnic ? `<div style="font-size:.75rem;color:#9AAACB;">${cnic}</div>` : ''}</div>`;
        },
        templateSelection: function (client) {
            if (!client.id) return client.text;
            return $(client.element).data('name') || client.text;
        },
    });

    /* Service Select2 */
    $('#service_id').select2({
        width: '100%',
        dropdownParent: $('body'),
        placeholder: 'Select client first…',
        allowClear: true,
    });
    $('#service_id').prop('disabled', true);

    /* Client change → load services */
    $('#client_id').on('change', function () {
        const clientId = $(this).val();
        const $svc  = $('#service_id');
        const $ring = $('#serviceLoadingRing');

        $svc.prop('disabled', true).empty().append('<option value=""></option>').trigger('change');

        if (!clientId) {
            setServiceHint('idle', 'Choose a client to load available services');
            $ring.hide();
            return;
        }

        $ring.show();
        setServiceHint('loading', 'Loading services…');

        $.ajax({
            url: '/client-services/' + clientId,
            type: 'GET',
            success: function (data) {
                $ring.hide();
                $svc.empty();
                if (data.length > 0) {
                    $svc.append('<option value="">Select a service…</option>');
                    $.each(data, function (_, item) {
                        $svc.append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    $svc.prop('disabled', false).trigger('change');
                    setServiceHint('loaded', data.length + ' service' + (data.length > 1 ? 's' : '') + ' available');
                } else {
                    $svc.append('<option value="">No active services</option>');
                    setServiceHint('empty', 'This client has no active services assigned');
                }
            },
            error: function () {
                $ring.hide();
                $svc.empty().append('<option value="">Failed to load services</option>');
                $svc.prop('disabled', false);
                setServiceHint('error', 'Could not load services — please try again');
            },
        });
    });

    @if(old('client_id'))
        $('#client_id').trigger('change');
    @endif

    /* Wire up the Add Files button */
    document.getElementById('addDocumentBtn').addEventListener('click', openFilePicker);

    updateCounts();
});
</script>
@endsection