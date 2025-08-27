<style>
    /* Enhanced Custom Styles */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --info-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .bg-gradient-primary {
        background: var(--primary-gradient) !important;
    }

    .stats-card {
        transition: all 0.3s ease;
        border-radius: 15px;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .card {
        border-radius: 15px;
    }

    .btn {
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
        background: var(--success-gradient);
        border: none;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
    }

    .btn-success:hover {
        box-shadow: 0 6px 20px rgba(17, 153, 142, 0.4);
    }

    .badge {
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .toast {
        border-radius: 15px;
        min-width: 350px;
        backdrop-filter: blur(10px);
    }

    .toast-header {
        border-radius: 15px 15px 0 0;
    }

    .toast-body {
        border-radius: 0 0 15px 15px;
    }

    .breadcrumb-light .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.7);
    }

    .text-white-75 {
        color: rgba(255, 255, 255, 0.75) !important;
    }

    .bg-primary-subtle {
        background-color: rgba(102, 126, 234, 0.1) !important;
    }

    .bg-success-subtle {
        background-color: rgba(17, 153, 142, 0.1) !important;
    }

    .bg-info-subtle {
        background-color: rgba(102, 126, 234, 0.1) !important;
    }

    .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .text-primary {
        color: #667eea !important;
    }

    .text-success {
        color: #11998e !important;
    }

    .text-info {
        color: #667eea !important;
    }

    .text-warning {
        color: #f5576c !important;
    }

    /* Table Specific Styles */
    .quiz-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .quiz-table thead th {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        color: #495057;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .quiz-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
    }

    .quiz-table tbody tr:hover {
        background-color: #f8f9ff !important;
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
    }

    .quiz-table tbody tr:nth-child(even) {
        background-color: #fafbff;
    }

    .quiz-table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .quiz-table td {
        vertical-align: middle;
        border: none;
        padding: 1rem 0.75rem;
    }

    .quiz-table .btn-group {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .quiz-table .btn-group .btn {
        border-radius: 0;
        border: none;
        padding: 0.5rem 0.75rem;
    }

    .quiz-table .btn-group .btn:first-child {
        border-radius: 8px 0 0 8px;
    }

    .quiz-table .btn-group .btn:last-child {
        border-radius: 0 8px 8px 0;
    }

    .copy-quiz-btn {
        transition: all 0.2s ease;
    }

    .copy-quiz-btn:hover {
        transform: scale(1.1);
    }

    /* Loading animation for table rows */
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .quiz-row {
        animation: slideInLeft 0.6s ease forwards;
    }

    .quiz-row:nth-child(2) {
        animation-delay: 0.1s;
    }

    .quiz-row:nth-child(3) {
        animation-delay: 0.2s;
    }

    .quiz-row:nth-child(4) {
        animation-delay: 0.3s;
    }

    .quiz-row:nth-child(5) {
        animation-delay: 0.4s;
    }

    /* Responsive table improvements */
    @media (max-width: 1200px) {

        .quiz-table th,
        .quiz-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
    }

    @media (max-width: 992px) {
        .quiz-table {
            font-size: 0.8rem;
        }

        .quiz-table .btn-group .btn {
            padding: 0.375rem 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .table-responsive {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .quiz-table tbody tr:hover {
            transform: none;
        }
    }

    /* Focus states for accessibility */
    .btn:focus,
    .copy-quiz-btn:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
        outline: none;
    }

    /* Print styles */
    @media print {
        .quiz-table {
            font-size: 0.75rem;
        }

        .quiz-table .btn-group {
            display: none;
        }

        .quiz-table tbody tr {
            break-inside: avoid;
        }

        .stats-card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar for table */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Enhanced badge styles */
    .badge {
        display: inline-flex;
        align-items: center;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* Animation for success feedback */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .btn-success.pulse {
        animation: pulse 0.3s ease-in-out;
    }

    /* Enhanced button group styling */
    .btn-group .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
    }

    .btn-group .btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        border-color: #17a2b8;
    }

    .btn-group .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        border-color: #ffc107;
        color: #212529;
    }

    .btn-group .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        border-color: #dc3545;
    }

    /* Tooltip-like effect for truncated text */
    .quiz-table td[title]:hover {
        position: relative;
        cursor: help;
    }

    /* Status badge animations */
    .badge {
        transition: all 0.3s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    /* Icon animations */
    .ti {
        transition: transform 0.2s ease;
    }

    .btn:hover .ti {
        transform: scale(1.1);
    }

    /* Table header sorting indicators (if needed) */
    .quiz-table th.sortable {
        cursor: pointer;
        user-select: none;
    }

    .quiz-table th.sortable:hover {
        background-color: #e9ecef;
    }

    /* Loading state styles */
    .table-loading {
        position: relative;
        opacity: 0.6;
        pointer-events: none;
    }

    .table-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin: -20px 0 0 -20px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Enhanced mobile responsiveness */
    @media (max-width: 576px) {
        .quiz-table thead {
            display: none;
        }

        .quiz-table tbody tr {
            display: block;
            border: 1px solid #dee2e6;
            border-radius: 15px;
            margin-bottom: 1rem;
            padding: 1rem;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .quiz-table tbody td {
            display: block;
            text-align: left !important;
            border: none;
            padding: 0.5rem 0;
        }

        .quiz-table tbody td:before {
            content: attr(data-label) ": ";
            font-weight: bold;
            color: #667eea;
        }

        .quiz-table .btn-group {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }

        .quiz-table .btn-group .btn {
            flex: 1;
            margin: 0 2px;
            border-radius: 8px !important;
        }
    }

    /* Enhanced mobile responsiveness - Replace the existing mobile section */
    @media (max-width: 768px) {

        /* Container adjustments */
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Header section mobile */
        .card.bg-gradient-primary .row {
            flex-direction: column;
            text-align: center;
        }

        .card.bg-gradient-primary .col-3 {
            margin-top: 1rem;
        }

        /* Action section mobile */
        .card-body .row.align-items-center {
            flex-direction: column;
            text-align: center;
        }

        .col-md-4.text-md-end {
            margin-top: 1rem;
            text-align: center !important;
        }

        /* Mobile table - Hide desktop table */
        .table-responsive .quiz-table {
            display: none;
        }

        /* Create mobile card layout */
        .mobile-quiz-container {
            display: block;
        }

        .mobile-quiz-card {
            background: white;
            border-radius: 15px;
            margin-bottom: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .mobile-quiz-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        /* Mobile card header */
        .mobile-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .mobile-card-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .mobile-card-title {
            flex: 1;
        }

        .mobile-card-title h6 {
            margin: 0;
            font-weight: bold;
            color: #333;
            font-size: 1.1rem;
            line-height: 1.3;
        }

        /* Mobile card info rows */
        .mobile-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
        }

        .mobile-info-row:not(:last-child) {
            border-bottom: 1px solid #f8f9fa;
        }

        .mobile-info-label {
            font-weight: 600;
            color: #667eea;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            min-width: 100px;
        }

        .mobile-info-label i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .mobile-info-value {
            text-align: right;
            flex: 1;
            margin-left: 1rem;
        }

        /* Code quiz section in mobile */
        .mobile-code-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .mobile-code-section .badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }

        .mobile-copy-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Mobile action buttons */
        .mobile-actions {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 2px solid #f8f9fa;
        }

        .mobile-action-row {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .mobile-action-row:last-child {
            margin-bottom: 0;
        }

        /* Mobile button adjustments */
        .mobile-actions .btn {
            flex: 1;
            padding: 0.75rem;
            font-size: 0.85rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .mobile-actions .btn i {
            font-size: 1rem;
        }

        /* Status activation button full width on mobile */
        .mobile-activation-btn {
            width: 100%;
            padding: 0.75rem;
            font-size: 0.9rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        /* Mobile badges */
        .mobile-info-value .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            white-space: nowrap;
        }

        /* Participant count styling */
        .participant-count {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .participant-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(17, 153, 142, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Toast adjustments for mobile */
        .toast {
            min-width: 280px;
            max-width: calc(100vw - 2rem);
        }

        /* Responsive font sizes */
        h3 {
            font-size: 1.5rem;
        }

        h5 {
            font-size: 1.2rem;
        }

        h6 {
            font-size: 1rem;
        }

        /* Button group adjustments */
        .btn-group {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .btn-group .btn {
            flex: 1;
            border-radius: 6px !important;
            min-width: calc(50% - 0.125rem);
            margin: 0;
            padding: 0.5rem 0.25rem;
            font-size: 0.8rem;
        }

        /* Empty state mobile adjustments */
        .text-center .rounded-circle {
            width: 80px !important;
            height: 80px !important;
        }

        .text-center .ti {
            font-size: 36px !important;
        }

        .text-center h3 {
            font-size: 1.3rem;
        }

        .text-center p {
            font-size: 0.9rem;
        }
    }

    /* Extra small devices */
    @media (max-width: 576px) {
        .mobile-quiz-card {
            padding: 1rem;
            margin-bottom: 0.75rem;
        }

        .mobile-card-header {
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .mobile-card-number {
            margin-bottom: 0.75rem;
            margin-right: 0;
        }

        .mobile-info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .mobile-info-value {
            text-align: left;
            margin-left: 0;
            width: 100%;
        }

        .mobile-code-section {
            width: 100%;
            justify-content: flex-start;
        }

        .participant-count {
            justify-content: flex-start;
        }

        .mobile-action-row {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn {
            min-width: 100%;
            margin-bottom: 0.25rem;
        }
    }

    /* Show mobile layout only on mobile */
    @media (min-width: 769px) {
        .mobile-quiz-container {
            display: none !important;
        }
    }
</style>
