<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résumé du Projet: {{ $projet->titre }}</title>
    <style>
        /* Styles généraux */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        h1 {
            font-size: 18pt;
            color: #333;
            margin: 0 0 5px 0;
        }

        .subtitle {
            font-size: 11pt;
            color: #666;
            margin: 0;
        }

        /* Badges de statut */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 9pt;
            font-weight: bold;
            margin: 10px 0;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-approved {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-rejected {
            background-color: #FEE2E2;
            color: #B91C1C;
        }

        /* Sections */
        .section {
            margin: 20px 0;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #E5E7EB;
        }

        /* Tableaux */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-grid th, .info-grid td {
            padding: 8px;
            text-align: left;
        }

        .info-grid th {
            background-color: #F3F4F6;
            font-weight: bold;
            width: 30%;
        }

        .info-grid tr {
            border-bottom: 1px solid #E5E7EB;
        }

        /* Boîtes d'information */
        .description-box, .promoteur-box, .rejection-box, .link-box {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .description-box {
            background-color: #F9FAFB;
            border-left: 4px solid #4F46E5;
        }

        .promoteur-box {
            background-color: #EFF6FF;
            border-left: 4px solid #3B82F6;
        }

        .rejection-box {
            background-color: #FEF2F2;
            border-left: 4px solid #EF4444;
        }

        .link-box {
            background-color: #F0F9FF;
            border: 1px dashed #0EA5E9;
            font-size: 9pt;
            word-break: break-word;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            font-size: 9pt;
            color: #6B7280;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .page-number {
            text-align: right;
            font-size: 8pt;
            color: #6B7280;
            position: fixed;
            bottom: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>Résumé du Projet</h1>
            <p class="subtitle">{{ config('app.name', 'Gestion des Projets') }}</p>
        </div>

        <!-- Statut du projet -->
        <div style="text-align: center;">
            @if($projet->statut === 'En Attente')
                <div class="status-badge status-pending">En Attente</div>
            @elseif($projet->statut === 'Validé')
                <div class="status-badge status-approved">Validé</div>
            @else
                <div class="status-badge status-rejected">Rejeté</div>
            @endif
        </div>

        <!-- Informations générales -->
        <div class="section">
            <h2 class="section-title">Informations générales</h2>
            <table class="info-grid">
                <tr>
                    <th>Titre</th>
                    <td>{{ $projet->titre }}</td>
                </tr>
                <tr>
                    <th>ID</th>
                    <td>#{{ $projet->id }}</td>
                </tr>
                <tr>
                    <th>Date de création</th>
                    <td>{{ date('d/m/Y à H:i', strtotime($projet->created_at)) }}</td>
                </tr>
                <tr>
                    <th>Dernière mise à jour</th>
                    <td>{{ date('d/m/Y à H:i', strtotime($projet->updated_at)) }}</td>
                </tr>
            </table>
        </div>

        <!-- Promoteur -->
        <div class="section">
            <h2 class="section-title">Promoteur</h2>
            <div class="promoteur-box">
                <p><strong>Nom:</strong> {{ $projet->user->nom }} {{ $projet->user->prenoms }}</p>
                <p><strong>Email:</strong> {{ $projet->user->email }}</p>
                <p><strong>Rôle:</strong> {{ ucfirst($projet->user->role) }}</p>
                <p><strong>ID:</strong> #{{ $projet->user->id }}</p>
            </div>
        </div>

        <!-- Détails du projet -->
        <div class="section">
            <h2 class="section-title">Détails</h2>
            <table class="info-grid">
                <tr>
                    <th>Type</th>
                    <td>{{ $projet->type }}</td>
                </tr>
                <tr>
                    <th>Forme juridique</th>
                    <td>{{ $projet->forme_juridique }}</td>
                </tr>
            </table>
            <h3>Description</h3>
            <div class="description-box">
                <p>{{ $projet->description ?: 'Aucune description fournie.' }}</p>
            </div>
        </div>

        <!-- Justification du rejet -->
        @if($projet->statut === 'Rejeté' && $projet->justification_rejet)
            <div class="section">
                <h2 class="section-title">Justification du rejet</h2>
                <div class="rejection-box">
                    <p>{{ $projet->justification_rejet }}</p>
                </div>
            </div>
        @endif

        <!-- Pied de page -->
        <div class="footer">
            <p>Document généré le {{ date('d/m/Y à H:i') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Gestion des Projets') }}</p>
        </div>
    </div>
</body>
</html>
