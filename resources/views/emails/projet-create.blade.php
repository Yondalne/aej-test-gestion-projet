<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Créé</title>
    <style>
        /* Styles généraux */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin: 0;
        }

        .content {
            padding: 20px 0;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
            color: #777;
            font-size: 14px;
        }

        .project-info {
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #3b82f6;
        }

        .cta-button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }

        .cta-button:hover {
            background-color: #2563eb;
        }

        /* Responsive */
        @media screen and (max-width: 480px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }

            .cta-button {
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name', 'Notre Plateforme') }}</h1>
        </div>

        <div class="content">
            <p>Bonjour {{ $notifiable->nom }} {{ $notifiable->prenoms }},</p>

            <p>Nous avons le plaisir de vous informer qu'un nouveau projet a été créé avec succès.</p>

            <div class="project-info">
                <p><strong>Titre du projet :</strong> {{ $projet->titre }}</p>
                <p><strong>Date de création :</strong> {{ date('d/m/Y') }}</p>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/projets/' . $projet->id) }}" class="cta-button">Voir les détails du projet</a>
            </div>

            <p>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter.</p>
        </div>

        <div class="footer">
            <p>Merci d'utiliser notre plateforme !</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Notre Plateforme') }}. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
