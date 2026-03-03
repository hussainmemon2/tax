@extends('layouts.app')

@section('page-title', 'Assign Service')

@section('content')

    <style>
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 28px;
        }

        .page-header .eyebrow {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 4px;
        }

        .page-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .page-header p {
            font-size: .84rem;
            color: var(--text-sub);
            margin: 3px 0 0;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: #fff;
            font-size: .84rem;
            font-weight: 600;
            color: var(--text-main);
            text-decoration: none;
            transition: .2s;
            font-family: 'DM Sans', sans-serif;
            white-space: nowrap;
        }

        .btn-back:hover {
            border-color: var(--navy);
            color: var(--navy);
        }

        .assign-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .assign-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ── Form card ── */
        .form-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(15, 31, 61, .06);
            margin-bottom: 20px;
        }

        .form-card-header {
            padding: 17px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 11px;
            background: linear-gradient(90deg, #F8F9FC, #fff);
        }

        .fch-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .fch-gold {
            background: var(--gold-pale);
            border: 1px solid rgba(201, 168, 76, .2);
            color: var(--gold);
        }

        .fch-teal {
            background: rgba(13, 148, 136, .08);
            border: 1px solid rgba(13, 148, 136, .15);
            color: #0D9488;
        }

        .fch-green {
            background: rgba(16, 185, 129, .08);
            border: 1px solid rgba(16, 185, 129, .15);
            color: #059669;
        }

        .fch-title {
            font-family: 'Playfair Display', serif;
            font-size: .93rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .fch-sub {
            font-size: .73rem;
            color: var(--text-sub);
            margin: 2px 0 0;
        }

        .form-card-body {
            padding: 22px 24px;
        }

        /* ── Fields ── */
        .field-group {
            margin-bottom: 18px;
        }

        .field-group:last-child {
            margin-bottom: 0;
        }

        .field-group label {
            display: block;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #3D4F72;
            margin-bottom: 7px;
        }

        .field-group label .req {
            color: var(--gold);
            margin-left: 2px;
        }

        .field-wrap {
            position: relative;
        }

        .field-wrap .f-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9AAACB;
            font-size: .9rem;
            pointer-events: none;
            z-index: 5;
        }

        /* ── Select2 ── */
        .select2-container .select2-selection--single {
            height: 44px !important;
            border: 1.5px solid var(--border) !important;
            border-radius: 9px !important;
            padding: 0 14px 0 38px !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: .88rem !important;
            background: #fff !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important;
            line-height: 44px !important;
            color: var(--text-main) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #B0BEDB !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
            right: 12px !important;
        }

        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--gold) !important;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .11) !important;
            outline: none !important;
        }

        .select2-dropdown {
            border: 1.5px solid var(--border) !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 36px rgba(15, 31, 61, .14) !important;
            font-family: 'DM Sans', sans-serif !important;
            font-size: .88rem !important;
            z-index: 99999 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--gold-pale) !important;
            color: var(--text-main) !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background: #F0F4FF !important;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1.5px solid var(--border) !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            font-family: 'DM Sans', sans-serif !important;
        }

        .select2-search--dropdown .select2-search__field:focus {
            border-color: var(--gold) !important;
            outline: none !important;
        }

        /* ══ TAB SHELL ══ */
        .tab-shell {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: visible;
            box-shadow: 0 4px 24px rgba(15, 31, 61, .06);
            margin-bottom: 20px;
        }

        .tab-nav {
            display: flex;
            align-items: stretch;
            border-bottom: 2px solid var(--border);
            background: #F8F9FC;
            overflow-x: auto;
            scrollbar-width: none;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .tab-nav::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 15px 22px;
            font-family: 'DM Sans', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            color: var(--text-sub);
            border: none;
            background: none;
            cursor: pointer;
            white-space: nowrap;
            transition: color .18s, background .18s;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
        }

        .tab-btn i {
            font-size: .88rem;
            opacity: .65;
            transition: opacity .18s;
        }

        .tab-btn:hover {
            color: var(--text-main);
            background: rgba(201, 168, 76, .03);
        }

        .tab-btn:hover i {
            opacity: 1;
        }

        .tab-btn.active {
            color: var(--navy);
            border-bottom-color: var(--gold);
            background: #fff;
        }

        .tab-btn.active i {
            opacity: 1;
            color: var(--gold);
        }

        .tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 50px;
            font-size: .66rem;
            font-weight: 700;
            transition: background .18s, color .18s;
        }

        .tab-btn[data-tab="documents"] .tab-count {
            background: rgba(37, 99, 235, .08);
            color: #2563EB;
            border: 1px solid rgba(37, 99, 235, .18);
        }

        .tab-btn[data-tab="invoices"] .tab-count {
            background: rgba(13, 148, 136, .08);
            color: #0D9488;
            border: 1px solid rgba(13, 148, 136, .18);
        }

        .tab-btn[data-tab="payments"] .tab-count {
            background: rgba(16, 185, 129, .08);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, .18);
        }

        .tab-btn.active .tab-count {
            background: var(--gold) !important;
            color: var(--navy) !important;
            border-color: var(--gold) !important;
        }

        .tab-panels {
            padding: 24px;
        }

        .tab-panel {
            display: none;
            animation: fadeTabIn .22s ease both;
        }

        .tab-panel.active {
            display: block;
        }

        @keyframes fadeTabIn {
            from {
                opacity: 0;
                transform: translateY(7px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-add-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .tab-section-label {
            font-size: .67rem;
            font-weight: 700;
            letter-spacing: .13em;
            text-transform: uppercase;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .action-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: .83rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: transform .18s, box-shadow .18s, background .18s;
        }

        .action-add-btn:hover {
            transform: translateY(-2px);
        }

        .add-doc-btn {
            background: rgba(37, 99, 235, .07);
            color: #2563EB;
            border-color: rgba(37, 99, 235, .2);
        }

        .add-doc-btn:hover {
            background: rgba(37, 99, 235, .14);
            box-shadow: 0 4px 14px rgba(37, 99, 235, .12);
        }

        .add-inv-btn {
            background: rgba(13, 148, 136, .07);
            color: #0D9488;
            border-color: rgba(13, 148, 136, .2);
        }

        .add-inv-btn:hover {
            background: rgba(13, 148, 136, .14);
            box-shadow: 0 4px 14px rgba(13, 148, 136, .12);
        }

        .add-pay-btn {
            background: rgba(16, 185, 129, .07);
            color: #059669;
            border-color: rgba(16, 185, 129, .2);
        }

        .add-pay-btn:hover {
            background: rgba(16, 185, 129, .14);
            box-shadow: 0 4px 14px rgba(16, 185, 129, .12);
        }

        /* ══ DOCUMENT ATTACHMENT CARDS ══ */
        .doc-dropzone {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 36px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            background: #FAFBFD;
            margin-bottom: 4px;
        }

        .doc-dropzone:hover {
            border-color: #2563EB;
            background: rgba(37, 99, 235, .03);
        }

        .doc-dropzone i {
            font-size: 2rem;
            color: #C8D2E8;
            display: block;
            margin-bottom: 10px;
        }

        .doc-dropzone p {
            font-size: .85rem;
            color: var(--text-sub);
            margin: 0 0 4px;
            font-weight: 500;
        }

        .doc-dropzone span {
            font-size: .74rem;
            color: #B0BEDB;
        }

        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 12px;
        }

        .doc-attach-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 14px;
            position: relative;
            animation: itemIn .22s ease both;
            transition: border-color .2s, box-shadow .2s;
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .doc-attach-card:hover {
            border-color: rgba(37, 99, 235, .3);
            box-shadow: 0 4px 18px rgba(37, 99, 235, .08);
        }

        @keyframes itemIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .doc-card-top {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .doc-file-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
        }

        .doc-icon-pdf   { background: rgba(220,38,38,.1);  color: #DC2626; border: 1px solid rgba(220,38,38,.18); }
        .doc-icon-image { background: rgba(124,58,237,.1); color: #7C3AED; border: 1px solid rgba(124,58,237,.18); }
        .doc-icon-excel { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.18); }
        .doc-icon-word  { background: rgba(37,99,235,.1);  color: #2563EB; border: 1px solid rgba(37,99,235,.18); }
        .doc-icon-txt   { background: rgba(100,116,139,.1);color: #475569; border: 1px solid rgba(100,116,139,.18); }
        .doc-icon-other { background: rgba(201,168,76,.1); color: var(--gold); border: 1px solid rgba(201,168,76,.2); }

        .doc-file-meta {
            flex: 1;
            min-width: 0;
        }

        .doc-actual-name {
            font-size: .78rem;
            color: var(--text-sub);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
            margin-bottom: 2px;
        }

        .doc-filesize {
            font-size: .71rem;
            color: #B0BEDB;
            margin-top: 1px;
        }

        .doc-remove-btn {
            width: 26px;
            height: 26px;
            border-radius: 7px;
            flex-shrink: 0;
            border: 1.5px solid rgba(224, 82, 82, .2);
            background: rgba(224, 82, 82, .06);
            color: #E05252;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .72rem;
            cursor: pointer;
            transition: .15s;
        }

        .doc-remove-btn:hover {
            background: rgba(224, 82, 82, .18);
            border-color: rgba(224, 82, 82, .4);
        }

        /* ── Card inner fields (shared style) ── */
        .doc-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .doc-field label {
            font-size: .67rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--text-sub);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .doc-field label i {
            color: var(--gold);
            font-size: .72rem;
        }

        .doc-field input {
            width: 100%;
            padding: 8px 11px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: .83rem;
            color: var(--text-main);
            background: #F8F9FC;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .doc-field input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .1);
            background: #fff;
        }

        /* name field has a pencil-edit feel */
        .doc-field.name-field input {
            font-weight: 600;
            color: var(--text-main);
            background: #fff;
            border-color: rgba(201,168,76,.25);
        }

        .doc-field.name-field input:focus {
            border-color: var(--gold);
        }

        .doc-divider {
            height: 1px;
            background: var(--border);
            margin: 0 -14px;
        }

        .doc-hidden-file {
            display: none;
        }

        /* ── Invoice / Payment item cards ── */
        .item-card {
            background: #FAFBFD;
            border: 1.5px solid var(--border);
            border-radius: 11px;
            padding: 16px 18px;
            margin-bottom: 12px;
            position: relative;
            animation: itemIn .22s ease both;
        }

        .item-card:hover {
            border-color: rgba(201, 168, 76, .28);
        }

        .item-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .item-card-title {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: .86rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .item-num {
            width: 24px;
            height: 24px;
            border-radius: 7px;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy));
            color: var(--gold-lt);
            font-size: .72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .item-type-tag {
            font-size: .7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 50px;
        }

        .inv-tag {
            background: rgba(13, 148, 136, .08);
            color: #0D9488;
            border: 1px solid rgba(13, 148, 136, .18);
        }

        .pay-tag {
            background: rgba(16, 185, 129, .08);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, .18);
        }

        .btn-remove-item {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1.5px solid rgba(224, 82, 82, .2);
            background: rgba(224, 82, 82, .06);
            color: #E05252;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            cursor: pointer;
            transition: .15s;
            flex-shrink: 0;
        }

        .btn-remove-item:hover {
            background: rgba(224, 82, 82, .15);
        }

        .item-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 640px) {
            .item-fields {
                grid-template-columns: 1fr;
            }
        }

        .ifield label {
            display: block;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--text-sub);
            margin-bottom: 5px;
        }

        .ifield .pf-control {
            width: 100%;
            padding: 9px 13px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: .86rem;
            color: var(--text-main);
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            -webkit-appearance: none;
        }

        .ifield .pf-control::placeholder {
            color: #B0BEDB;
        }

        .ifield .pf-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .1);
        }

        .ifield .pf-control.is-invalid {
            border-color: #E05252;
        }

        .ifield .pf-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(224, 82, 82, .1);
        }

        .ifield .pf-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239AAACB' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 34px;
            cursor: pointer;
        }

        .ifield textarea.pf-control {
            min-height: 68px;
            resize: vertical;
        }

        .invalid-feedback {
            font-size: .75rem;
            color: #E05252;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .tab-empty {
            text-align: center;
            padding: 44px 20px;
            border: 2px dashed var(--border);
            border-radius: 12px;
            color: var(--text-sub);
            font-size: .84rem;
        }

        .tab-empty i {
            font-size: 1.6rem;
            color: #C8D2E8;
            display: block;
            margin-bottom: 10px;
        }

        .tab-empty p {
            margin: 0;
        }

        /* ── Summary card ── */
        .summary-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(15, 31, 61, .06);
            position: sticky;
            top: calc(var(--topbar-h, 70px) + 20px);
        }

        .summary-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .s-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(201, 168, 76, .2);
            border: 1px solid rgba(201, 168, 76, .3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-lt);
            font-size: .88rem;
        }

        .s-title {
            font-family: 'Playfair Display', serif;
            font-size: .95rem;
            font-weight: 700;
            color: #fff;
        }

        .s-sub {
            font-size: .72rem;
            color: rgba(255, 255, 255, .45);
            margin-top: 1px;
        }

        .summary-body {
            padding: 20px;
        }

        .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: .87rem;
        }

        .summary-row:last-of-type {
            border-bottom: none;
        }

        .s-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-sub);
            font-weight: 500;
        }

        .s-label i {
            font-size: .85rem;
        }

        .s-val {
            font-weight: 700;
            color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
        }

        .summary-row.outstanding .s-val { color: #E05252; }
        .summary-row.paid        .s-val { color: #059669; }

        .summary-progress { margin: 16px 0 0; }

        .prog-label {
            display: flex;
            justify-content: space-between;
            font-size: .72rem;
            font-weight: 600;
            color: var(--text-sub);
            margin-bottom: 6px;
        }

        .prog-track {
            height: 8px;
            background: #EDF1F8;
            border-radius: 50px;
            overflow: hidden;
        }

        .prog-fill {
            height: 100%;
            border-radius: 50px;
            background: linear-gradient(90deg, #059669, #34D399);
            transition: width .5s cubic-bezier(.4, 0, .2, 1);
            width: 0%;
        }

        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy));
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .92rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 16px rgba(11, 27, 53, .22);
            margin-top: 18px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(201, 168, 76, .12) 0%, transparent 60%);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(11, 27, 53, .3);
        }
    </style>

    <!-- ── Page Header ── -->
    <div class="page-header">
        <div>
            <div class="eyebrow">Client Services</div>
            <h2>Assign Service</h2>
            <p>Link a service to a client and attach documents, invoices &amp; payments</p>
        </div>
        <a href="{{ route('clients.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to Clients
        </a>
    </div>

    <form action="{{ route('client_services.store') }}" method="POST" enctype="multipart/form-data" id="assignServiceForm">
        @csrf

        <div class="assign-layout">

            <!-- ════ LEFT ════ -->
            <div>

                <!-- Assignment Details -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="fch-icon fch-gold"><i class="bi bi-person-check-fill"></i></div>
                        <div>
                            <div class="fch-title">Assignment Details</div>
                            <div class="fch-sub">Select the client and service to link</div>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="field-group">
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
                                                    {{ old('client_id') == $client->id ? 'selected' : '' }}
                                                    >
                                                    {{ $client->full_name }} {{ $client->cnic }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label>Service <span class="req">*</span></label>
                                    <div class="field-wrap">
                                        <i class="bi bi-briefcase f-icon"></i>
                                        <select name="service_id" id="service_id" class="select2" required style="width:100%;">
                                            <option value="">Select service…</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"  {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabbed sections -->
                <div class="tab-shell">

                    <div class="tab-nav" role="tablist">
                        <button type="button" class="tab-btn active" data-tab="documents" onclick="switchTab('documents', this)">
                            <i class="bi bi-paperclip"></i> Documents
                            <span class="tab-count" id="count-documents">0</span>
                        </button>
                        <button type="button" class="tab-btn" data-tab="invoices" onclick="switchTab('invoices', this)">
                            <i class="bi bi-receipt-cutoff"></i> Invoices
                            <span class="tab-count" id="count-invoices">0</span>
                        </button>
                        <button type="button" class="tab-btn" data-tab="payments" onclick="switchTab('payments', this)">
                            <i class="bi bi-cash-stack"></i> Payments
                            <span class="tab-count" id="count-payments">0</span>
                        </button>
                    </div>

                    <div class="tab-panels">

                        <!-- ══ DOCUMENTS ══ -->
                        <div class="tab-panel active" id="tab-documents">
                            <div class="tab-add-bar">
                                <span class="tab-section-label"><i class="bi bi-paperclip"></i> Attached Files</span>
                                <button type="button" class="action-add-btn add-doc-btn" id="addDocumentBtn">
                                    <i class="bi bi-file-earmark-plus"></i> Add Document
                                </button>
                            </div>

                            <div id="docs-empty" class="doc-dropzone" onclick="document.getElementById('addDocumentBtn').click()">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <p>Click to select files</p>
                                <span>PDF, Word, Excel, Images &amp; more</span>
                            </div>

                            <div class="doc-grid" id="documentsContainer"></div>
                        </div>

                        <!-- ══ INVOICES ══ -->
                        <div class="tab-panel" id="tab-invoices">
                            <div class="tab-add-bar">
                                <span class="tab-section-label"><i class="bi bi-receipt"></i> Billing Invoices</span>
                                <button type="button" class="action-add-btn add-inv-btn" id="addInvoiceBtn">
                                    <i class="bi bi-receipt-cutoff"></i> Add Invoice
                                </button>
                            </div>
                            <div id="invoicesContainer">
                                <div class="tab-empty" id="inv-empty">
                                    <i class="bi bi-receipt"></i>
                                    <p>No invoices yet. Click "Add Invoice" to create one.</p>
                                </div>
                            </div>
                        </div>

                        <!-- ══ PAYMENTS ══ -->
                        <div class="tab-panel" id="tab-payments">
                            <div class="tab-add-bar">
                                <span class="tab-section-label"><i class="bi bi-cash"></i> Payment Records</span>
                                <button type="button" class="action-add-btn add-pay-btn" id="addPaymentBtn">
                                    <i class="bi bi-cash-stack"></i> Add Payment
                                </button>
                            </div>
                            <div id="paymentsContainer">
                                <div class="tab-empty" id="pay-empty">
                                    <i class="bi bi-cash-coin"></i>
                                    <p>No payments yet. Click "Add Payment" to record one.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div><!-- /left -->

            <!-- ════ RIGHT — Summary ════ -->
            <div>
                <div class="summary-card">
                    <div class="summary-card-header">
                        <div class="s-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                        <div>
                            <div class="s-title">Financial Summary</div>
                            <div class="s-sub">Live — updates as you type</div>
                        </div>
                    </div>
                    <div class="summary-body">

                        <div class="summary-row">
                            <span class="s-label"><i class="bi bi-receipt" style="color:var(--gold);"></i> Total Invoiced</span>
                            <span class="s-val">PKR <span id="totalInvoiced">0.00</span></span>
                        </div>
                        <div class="summary-row paid">
                            <span class="s-label"><i class="bi bi-check-circle-fill" style="color:#059669;"></i> Total Paid</span>
                            <span class="s-val">PKR <span id="totalPaid">0.00</span></span>
                        </div>
                        <div class="summary-row outstanding">
                            <span class="s-label"><i class="bi bi-exclamation-circle-fill" style="color:#E05252;"></i> Outstanding</span>
                            <span class="s-val">PKR <span id="outstanding">0.00</span></span>
                        </div>

                        <div class="summary-progress">
                            <div class="prog-label">
                                <span>Payment Progress</span>
                                <span id="progressPct">0%</span>
                            </div>
                            <div class="prog-track">
                                <div class="prog-fill" id="progressBar"></div>
                            </div>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-top:18px;">
                            <div style="text-align:center;padding:10px 6px;background:#F8F9FC;border:1px solid var(--border);border-radius:9px;cursor:pointer;" onclick="switchTabByName('documents')">
                                <div style="font-size:1rem;font-weight:700;color:#2563EB;" id="sc-docs">0</div>
                                <div style="font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--text-sub);margin-top:2px;">Docs</div>
                            </div>
                            <div style="text-align:center;padding:10px 6px;background:#F8F9FC;border:1px solid var(--border);border-radius:9px;cursor:pointer;" onclick="switchTabByName('invoices')">
                                <div style="font-size:1rem;font-weight:700;color:#0D9488;" id="sc-inv">0</div>
                                <div style="font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--text-sub);margin-top:2px;">Invoices</div>
                            </div>
                            <div style="text-align:center;padding:10px 6px;background:#F8F9FC;border:1px solid var(--border);border-radius:9px;cursor:pointer;" onclick="switchTabByName('payments')">
                                <div style="font-size:1rem;font-weight:700;color:#059669;" id="sc-pay">0</div>
                                <div style="font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--text-sub);margin-top:2px;">Payments</div>
                            </div>
                        </div>

                        <button type="submit" form="assignServiceForm" class="btn-submit">
                            <i class="bi bi-check-circle-fill"></i> Assign Service
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
        /* ── Tab switching ── */
        function switchTab(name, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => { p.classList.remove('active'); p.style.display = 'none'; });
            btn.classList.add('active');
            const panel = document.getElementById('tab-' + name);
            if (panel) { panel.style.display = 'block'; panel.classList.remove('active'); void panel.offsetWidth; panel.classList.add('active'); }
        }

        function switchTabByName(name) {
            const btn = document.querySelector(`.tab-btn[data-tab="${name}"]`);
            if (btn) switchTab(name, btn);
            document.querySelector('.tab-shell')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.tab-panel').forEach(p => {
                if (!p.classList.contains('active')) p.style.display = 'none';
            });
        });

        /* ── File type helpers ── */
        function getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            if (ext === 'pdf')                                              return ['bi-file-earmark-pdf-fill',   'doc-icon-pdf'];
            if (['jpg','jpeg','png','gif','bmp','webp'].includes(ext))      return ['bi-file-earmark-image-fill', 'doc-icon-image'];
            if (['xls','xlsx','csv'].includes(ext))                         return ['bi-file-earmark-excel-fill', 'doc-icon-excel'];
            if (['doc','docx'].includes(ext))                               return ['bi-file-earmark-word-fill',  'doc-icon-word'];
            if (ext === 'txt')                                              return ['bi-file-earmark-text-fill',  'doc-icon-txt'];
            return ['bi-file-earmark-fill', 'doc-icon-other'];
        }

        function fmtBytes(b) {
            if (b < 1024)    return b + ' B';
            if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
            return (b / 1048576).toFixed(1) + ' MB';
        }

        /* Strip file extension to suggest a clean display name */
        function stripExt(filename) {
            return filename.replace(/\.[^/.]+$/, '');
        }

        /* ── Counter sync ── */
        function updateCounts() {
            const dc = document.querySelectorAll('#documentsContainer .doc-attach-card').length;
            const ic = document.querySelectorAll('#invoicesContainer .item-card').length;
            const pc = document.querySelectorAll('#paymentsContainer .item-card').length;

            ['count-documents','sc-docs'].forEach(id => document.getElementById(id).textContent = dc);
            ['count-invoices', 'sc-inv' ].forEach(id => document.getElementById(id).textContent = ic);
            ['count-payments', 'sc-pay' ].forEach(id => document.getElementById(id).textContent = pc);

            document.getElementById('docs-empty').style.display = dc === 0 ? 'block' : 'none';
            document.getElementById('inv-empty').style.display  = ic === 0 ? 'block' : 'none';
            document.getElementById('pay-empty').style.display  = pc === 0 ? 'block' : 'none';
        }

        $(document).ready(function () {

            /* ── Select2 ── */
            $('#client_id').select2({
                
                width: '100%',
                dropdownParent: $('body'),
                placeholder: 'Search client by name or CNIC',
                allowClear: true,
                templateResult: formatClient,
                templateSelection: formatClientSelection,
                escapeMarkup: function (markup) { return markup; }
            });
            $('#client_id').trigger('change');

            function formatClient(client) {
                if (!client.id) return client.text;
                const name = $(client.element).data('name');
                const cnic = $(client.element).data('cnic');
                return `<div><div style="font-weight:600;">${name}</div>${cnic ? `<div style="font-size:.75rem;color:#9AAACB;">${cnic}</div>` : ''}</div>`;
            }

            function formatClientSelection(client) {
                if (!client.id) return client.text;
                return $(client.element).data('name');
            }

            $('#service_id').select2({ width: '100%', dropdownParent: $('body') });
            $('#service_id').trigger('change');

            const today = new Date().toISOString().split('T')[0];
            let docIndex = 0, invoiceIndex = 0, paymentIndex = 0;

            /* ── Summary updater ── */
            function updateSummary() {
                let totalInvoiced = 0;
                $('input[name^="invoices"][name$="[total_amount]"]').each(function () { totalInvoiced += parseFloat($(this).val()) || 0; });
                let totalPaid = 0;
                $('.payment-amount').each(function () { totalPaid += parseFloat($(this).val()) || 0; });
                const outstanding = totalInvoiced - totalPaid;
                const pct = totalInvoiced > 0 ? Math.min(100, (totalPaid / totalInvoiced) * 100) : 0;
                $('#totalInvoiced').text(totalInvoiced.toFixed(2));
                $('#totalPaid').text(totalPaid.toFixed(2));
                $('#outstanding').text(outstanding.toFixed(2));
                $('#progressBar').css('width', pct.toFixed(1) + '%');
                $('#progressPct').text(pct.toFixed(0) + '%');

                let runningTotal = 0;
                $('.payment-amount').each(function () {
                    const val = parseFloat($(this).val()) || 0;
                    runningTotal += val;
                    $(this).next('.invalid-feedback').remove();
                    if (runningTotal > totalInvoiced) {
                        $(this).addClass('is-invalid');
                        $(this).after('<div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> Overpayment! Total payments cannot exceed total invoiced.</div>');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
            }
            @if(old('invoices'))
                let oldInvoices = @json(old('invoices'));
                Object.keys(oldInvoices).forEach(function(key){
                    invoiceIndex++; // manually increment
                    let inv = oldInvoices[key];

                    $('#invoicesContainer').append(`
                        <div class="item-card" id="invoice-${invoiceIndex}">
                            <div class="item-card-header">
                                <div class="item-card-title">
                                    <div class="item-num">${invoiceIndex}</div>
                                    <span class="item-type-tag inv-tag"><i class="bi bi-receipt me-1"></i>Invoice ${invoiceIndex}</span>
                                </div>
                                <button type="button" class="btn-remove-item remove-invoice" data-id="${invoiceIndex}"><i class="bi bi-x-lg"></i></button>
                            </div>
                            <div class="item-fields">
                                <div class="ifield">
                                    <label>Invoice Narration <span style="color:var(--gold);">*</span></label>
                                    <input type="text" name="invoices[${invoiceIndex}][narration]" class="pf-control" placeholder="e.g. Invoice for services rendered" required value="${inv.narration ?? ''}">
                                </div>
                                <div class="ifield">
                                    <label>Total Amount <span style="color:var(--gold);">*</span></label>
                                    <input type="number" name="invoices[${invoiceIndex}][total_amount]" class="pf-control invoice-amount" placeholder="0.00" min="0" required value="${inv.total_amount ?? ''}">
                                </div>
                                <div class="ifield">
                                    <label>Issued Date</label>
                                    <input type="date" name="invoices[${invoiceIndex}][issued_date]" class="pf-control" value="${inv.issued_date ?? '${today}'}">
                                </div>
                            </div>
                        </div>
                    `);
                });
            @endif
            /* Restore old payments */
            @if(old('payments'))
                let oldPayments = @json(old('payments'));
                Object.keys(oldPayments).forEach(function(key){
                    paymentIndex++; // manually increment
                    let pay = oldPayments[key];

                    $('#paymentsContainer').append(`
                        <div class="item-card" id="payment-${paymentIndex}">
                            <div class="item-card-header">
                                <div class="item-card-title">
                                    <div class="item-num">${paymentIndex}</div>
                                    <span class="item-type-tag pay-tag"><i class="bi bi-cash me-1"></i>Payment ${paymentIndex}</span>
                                </div>
                                <button type="button" class="btn-remove-item remove-payment" data-id="${paymentIndex}"><i class="bi bi-x-lg"></i></button>
                            </div>
                            <div class="item-fields">
                                <div class="ifield">
                                    <label>Amount <span style="color:var(--gold);">*</span></label>
                                    <input type="number" step="0.01" name="payments[${paymentIndex}][amount]" class="pf-control payment-amount" placeholder="0.00" min="0" required value="${pay.amount ?? ''}">
                                </div>
                                <div class="ifield">
                                    <label>Payment Method <span style="color:var(--gold);">*</span></label>
                                    <select name="payments[${paymentIndex}][payment_method]" class="pf-control pf-select" required>
                                        <option value="">Select method…</option>
                                        <option value="cash" ${pay.payment_method === 'cash' ? 'selected' : ''}>Cash</option>
                                        <option value="bank_transfer" ${pay.payment_method === 'bank_transfer' ? 'selected' : ''}>Bank Transfer</option>
                                        <option value="card" ${pay.payment_method === 'card' ? 'selected' : ''}>Card</option>
                                        <option value="check" ${pay.payment_method === 'check' ? 'selected' : ''}>Check</option>
                                        <option value="online" ${pay.payment_method === 'online' ? 'selected' : ''}>Online</option>
                                    </select>
                                </div>
                                <div class="ifield">
                                    <label>Reference No.</label>
                                    <input type="text" name="payments[${paymentIndex}][reference_no]" class="pf-control" placeholder="e.g. TXN-00123" value="${pay.reference_no ?? ''}">
                                </div>
                                <div class="ifield">
                                    <label>Payment Date</label>
                                    <input type="date" name="payments[${paymentIndex}][payment_date]" class="pf-control" value="${pay.payment_date ?? '${today}'}">
                                </div>
                                <div class="ifield" style="grid-column:1/-1;">
                                    <label>Notes</label>
                                    <textarea name="payments[${paymentIndex}][notes]" class="pf-control" placeholder="Optional notes…">${pay.notes ?? ''}</textarea>
                                </div>
                            </div>
                        </div>
                    `);
                });
            @endif
            updateSummary();
            updateCounts();
            @if($errors->any())
                let errorTab = null;

                @foreach($errors->keys() as $key)
                    @if(str_starts_with($key, 'documents'))
                        errorTab = 'documents';
                    @elseif(str_starts_with($key, 'invoices'))
                        errorTab = 'invoices';
                    @elseif(str_starts_with($key, 'payments'))
                        errorTab = 'payments';
                    @endif
                @endforeach

                if (errorTab) {
                    switchTabByName(errorTab);
                }
            @endif
            /* ── DOCUMENTS ── */
            const allowedExtensions = ['.jpg','.jpeg','.png','.gif','.bmp','.webp','.pdf','.doc','.docx','.xls','.xlsx','.csv','.txt'];

            function openFilePicker() {
                const fileInput = $('<input type="file" multiple accept="' + allowedExtensions.join(',') + '" style="display:none">');
                $('body').append(fileInput);
                fileInput.trigger('click');

                fileInput.on('change', function (e) {
                    Array.from(e.target.files).forEach(file => {
                        const ext = '.' + file.name.split('.').pop().toLowerCase();
                        if (!allowedExtensions.includes(ext)) {
                            alert(`File "${file.name}" is not allowed. Allowed: ${allowedExtensions.join(', ')}`);
                            return;
                        }

                        docIndex++;
                        const [iconClass, colorClass] = getFileIcon(file.name);

                        // Pre-fill name = filename without extension, editable by user
                        const defaultName = stripExt(file.name);

                        const card = $(`
                            <div class="doc-attach-card" id="document-${docIndex}">

                                {{-- Top: file icon + actual filename + size + remove btn --}}
                                <div class="doc-card-top">
                                    <div class="doc-file-icon ${colorClass}">
                                        <i class="bi ${iconClass}"></i>
                                    </div>
                                    <div class="doc-file-meta">
                                        <div class="doc-actual-name" title="${file.name}">${file.name}</div>
                                        <div class="doc-filesize">${fmtBytes(file.size)}</div>
                                    </div>
                                    <button type="button" class="doc-remove-btn remove-document" data-id="${docIndex}" title="Remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>

                                <div class="doc-divider"></div>

                                {{-- Editable document name — pre-filled, user can change --}}
                                <div class="doc-field name-field">
                                    <label><i class="bi bi-pencil"></i> Document Name</label>
                                    <input
                                        type="text"
                                        name="documents[${docIndex}][filename]"
                                        value="${defaultName}"
                                        placeholder="Enter document name…"
                                        maxlength="200"
                                    >
                                </div>

                                {{-- Document date --}}
                                <div class="doc-field">
                                    <label><i class="bi bi-calendar3"></i> Document Date</label>
                                    <input
                                        type="date"
                                        name="documents[${docIndex}][document_date]"
                                        value="${today}"
                                    >
                                </div>

                                {{-- Hidden actual file input --}}
                                <input
                                    type="file"
                                    name="documents[${docIndex}][file]"
                                    class="doc-hidden-file single-file-input"
                                    required
                                >
                            </div>
                        `);

                        $('#documentsContainer').append(card);

                        // Inject the file object into the hidden input via DataTransfer
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        card.find('.single-file-input')[0].files = dt.files;

                        updateCounts();
                    });
                    fileInput.remove();
                });
            }

            $('#addDocumentBtn').click(openFilePicker);
            $('#docs-empty').click(function (e) {
                if ($(e.target).closest('.action-add-btn').length === 0) openFilePicker();
            });

            $(document).on('click', '.remove-document', function () {
                $(`#document-${$(this).data('id')}`).remove();
                updateCounts();
            });

            /* ── INVOICES ── */
            $('#addInvoiceBtn').click(function () {
                invoiceIndex++;
                $('#invoicesContainer').append(`
                    <div class="item-card" id="invoice-${invoiceIndex}">
                        <div class="item-card-header">
                            <div class="item-card-title">
                                <div class="item-num">${invoiceIndex}</div>
                                <span class="item-type-tag inv-tag"><i class="bi bi-receipt me-1"></i>Invoice ${invoiceIndex}</span>
                            </div>
                            <button type="button" class="btn-remove-item remove-invoice" data-id="${invoiceIndex}"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="item-fields">
                            <div class="ifield">
                                <label>Invoice Narration <span style="color:var(--gold);">*</span></label>
                                <input type="text" name="invoices[${invoiceIndex}][narration]" class="pf-control" placeholder="e.g. Invoice for services rendered" required>
                            </div>
                            <div class="ifield">
                                <label>Total Amount <span style="color:var(--gold);">*</span></label>
                                <input type="number" name="invoices[${invoiceIndex}][total_amount]" class="pf-control invoice-amount" placeholder="0.00" min="0" required>
                            </div>
                            <div class="ifield">
                                <label>Issued Date</label>
                                <input type="date" name="invoices[${invoiceIndex}][issued_date]" class="pf-control" value="${today}">
                            </div>
                        </div>
                    </div>
                `);
                updateCounts();
            });

            $(document).on('input',  '.invoice-amount',  updateSummary);
            $(document).on('click', '.remove-invoice',  function () { $(this).closest('.item-card').remove(); updateSummary(); updateCounts(); });

            /* ── PAYMENTS ── */
            $('#addPaymentBtn').click(function () {
                paymentIndex++;
                $('#paymentsContainer').append(`
                    <div class="item-card" id="payment-${paymentIndex}">
                        <div class="item-card-header">
                            <div class="item-card-title">
                                <div class="item-num">${paymentIndex}</div>
                                <span class="item-type-tag pay-tag"><i class="bi bi-cash me-1"></i>Payment ${paymentIndex}</span>
                            </div>
                            <button type="button" class="btn-remove-item remove-payment" data-id="${paymentIndex}"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="item-fields">
                            <div class="ifield">
                                <label>Amount <span style="color:var(--gold);">*</span></label>
                                <input type="number" step="0.01" name="payments[${paymentIndex}][amount]" class="pf-control payment-amount" placeholder="0.00" min="0" required>
                            </div>
                            <div class="ifield">
                                <label>Payment Method <span style="color:var(--gold);">*</span></label>
                                <select name="payments[${paymentIndex}][payment_method]" class="pf-control pf-select" required>
                                    <option value="">Select method…</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="card">Card</option>
                                    <option value="check">Check</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="ifield">
                                <label>Reference No.</label>
                                <input type="text" name="payments[${paymentIndex}][reference_no]" class="pf-control" placeholder="e.g. TXN-00123">
                            </div>
                            <div class="ifield">
                                <label>Payment Date</label>
                                <input type="date" name="payments[${paymentIndex}][payment_date]" class="pf-control" value="${today}">
                            </div>
                            <div class="ifield" style="grid-column:1/-1;">
                                <label>Notes</label>
                                <textarea name="payments[${paymentIndex}][notes]" class="pf-control" placeholder="Optional notes…"></textarea>
                            </div>
                        </div>
                    </div>
                `);
                updateCounts();
            });

            $(document).on('input',  '.payment-amount', updateSummary);
            $(document).on('click', '.remove-payment', function () { $(this).closest('.item-card').remove(); updateSummary(); updateCounts(); });

            updateCounts();
        });
    </script>
@endsection