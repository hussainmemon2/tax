<style>
    /* ── Table ── */
    .data-table-wrap { overflow-x: auto; }
    .data-table {
        width: 100%; border-collapse: collapse;
        font-family: 'DM Sans', sans-serif; font-size: .875rem;
    }
    .data-table thead tr { border-bottom: 2px solid var(--border); background: #F8F9FC; }
    .data-table thead th {
        padding: 11px 16px; font-size: .67rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase; color: #3D4F72; white-space: nowrap;
    }
    .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #FAFBFD; }
    .data-table tbody td { padding: 13px 16px; color: var(--text-main); vertical-align: middle; }

    /* ── File icon block ── */
    .doc-name-cell { display: flex; align-items: center; gap: 11px; }
    .doc-type-icon {
        width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1rem;
    }
    .dti-pdf   { background: rgba(220,38,38,.09);  color: #DC2626; border: 1px solid rgba(220,38,38,.16); }
    .dti-word  { background: rgba(37,99,235,.09);  color: #2563EB; border: 1px solid rgba(37,99,235,.16); }
    .dti-excel { background: rgba(16,185,129,.09); color: #059669; border: 1px solid rgba(16,185,129,.16); }
    .dti-image { background: rgba(124,58,237,.09); color: #7C3AED; border: 1px solid rgba(124,58,237,.16); }
    .dti-other { background: rgba(100,116,139,.09);color: #475569; border: 1px solid rgba(100,116,139,.16); }

    .doc-name-text { font-weight: 600; font-size: .875rem; color: var(--text-main); line-height: 1.25; }
    .doc-meta-text { font-size: .72rem; color: #9AAACB; margin-top: 2px; }

    /* ── Date cell ── */
    .date-cell { font-size: .83rem; color: var(--text-sub); white-space: nowrap; }

    /* ── Client chip ── */
    .client-chip { display: inline-flex; align-items: center; gap: 6px; font-size: .83rem; font-weight: 600; color: var(--text-main); }
    .chip-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }

    /* ── Service badge ── */
    .svc-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: .72rem; font-weight: 600; padding: 3px 10px; border-radius: 50px;
        background: rgba(11,27,53,.05); color: var(--navy);
        border: 1px solid rgba(11,27,53,.1); white-space: nowrap;
    }

    /* ── Action buttons ── */
    .tbl-actions { display: flex; align-items: center; gap: 6px; }
    .tbl-btn {
        width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .82rem; cursor: pointer; transition: .18s;
        text-decoration: none; border: 1.5px solid;
    }
    .tbl-btn-eye {
        border-color: rgba(13,148,136,.2); background: rgba(13,148,136,.06); color: #0D9488;
    }
    .tbl-btn-eye:hover { background: #0D9488; color: #fff; border-color: #0D9488; }

    .tbl-btn-dl {
        border-color: rgba(37,99,235,.2); background: rgba(37,99,235,.06); color: #2563EB;
    }
    .tbl-btn-dl:hover { background: #2563EB; color: #fff; border-color: #2563EB; }

    /* ── Empty state ── */
    .table-empty {
        text-align: center; padding: 60px 20px; color: var(--text-sub); font-size: .85rem;
    }
    .table-empty i { font-size: 2.2rem; color: #C8D2E8; display: block; margin-bottom: 14px; }
    .table-empty p { margin: 0; }

    /* ── Pagination ── */
    .pagination-wrap { padding: 14px 16px; border-top: 1px solid var(--border); }
    .pagination-wrap .pagination { margin: 0; gap: 4px; }
    .pagination-wrap .page-link {
        border-radius: 8px !important; border: 1.5px solid var(--border) !important;
        color: var(--text-main) !important; font-family: 'DM Sans', sans-serif !important;
        font-size: .82rem !important; font-weight: 600 !important; padding: 6px 12px !important; transition: .15s !important;
    }
    .pagination-wrap .page-link:hover { border-color: var(--navy) !important; color: var(--navy) !important; background: #fff !important; }
    .pagination-wrap .page-item.active .page-link { background: var(--navy) !important; border-color: var(--navy) !important; color: #fff !important; }
    .pagination-wrap .page-item.disabled .page-link { opacity: .4 !important; }
</style>

@php
    function docIconClass($mime) {
        if (str_contains($mime, 'pdf'))   return ['bi-file-earmark-pdf-fill',   'dti-pdf'];
        if (str_contains($mime, 'word'))  return ['bi-file-earmark-word-fill',  'dti-word'];
        if (str_contains($mime, 'excel') || str_contains($mime, 'spreadsheet')) return ['bi-file-earmark-excel-fill', 'dti-excel'];
        if (str_contains($mime, 'image')) return ['bi-file-earmark-image-fill', 'dti-image'];
        return ['bi-file-earmark-fill', 'dti-other'];
    }
@endphp

@if($documents->isEmpty())
    <div class="table-empty">
        <i class="bi bi-folder2-open"></i>
        <p>No documents found matching your filters.</p>
    </div>
@else
    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Document</th>
                    <th>Doc Date</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                @php [$iconCls, $colorCls] = docIconClass($doc->mime_type ?? ''); @endphp
                <tr>
                    {{-- Document name + meta --}}
                    <td>
                        <div class="doc-name-cell">
                            <div class="doc-type-icon {{ $colorCls }}">
                                <i class="bi {{ $iconCls }}"></i>
                            </div>
                            <div>
                                <div class="doc-name-text">{{ $doc->file_name }}</div>
                                <div class="doc-meta-text">
                                    {{ strtoupper(pathinfo($doc->file_name, PATHINFO_EXTENSION)) }}
                                    &bull;
                                    {{ number_format($doc->file_size / 1024, 1) }} KB
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Document date --}}
                    <td>
                        <span class="date-cell">
                            {{ $doc->documentdate ? \Carbon\Carbon::parse($doc->documentdate)->format('d M Y') : '—' }}
                        </span>
                    </td>

                    {{-- Client --}}
                    <td>
                        <span class="client-chip">
                            <span class="chip-dot"></span>
                            {{ $doc->client->full_name ?? '—' }}
                        </span>
                        <br>
                        <b>CNIC:</b> {{ $doc->client->cnic ?? '—' }}
                    </td>

                    {{-- Service --}}
                    <td>
                        <span class="svc-badge">
                            <i class="bi bi-briefcase"></i>
                            {{ $doc->clientService->service->name ?? 'General' }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="tbl-actions">
                            <button
                                type="button"
                                class="tbl-btn tbl-btn-eye"
                                onclick="previewFile('{{ Storage::url($doc->file_path) }}','{{ $doc->mime_type }}')"
                                title="Preview">
                                <i class="bi bi-eye"></i>
                            </button>
                            <a
                                href="{{ route('documents.download', $doc->id) }}"
                                class="tbl-btn tbl-btn-dl"
                                title="Download">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $documents->links() }}
    </div>
@endif