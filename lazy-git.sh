#!/bin/bash

# Vérification des arguments
if [ -z "$1" ] || [ -z "$2" ]; then
    echo "❌ Erreur : Tu dois fournir 2 arguments."
    echo "Format : ./lazy-git.sh <fichiers_ou_dossiers> <message_du_commit>"
    echo "Exemple : ./lazy-git.sh \"auth/ bdd/\" \"Ajout des modules de connexion et BDD\""
    echo "Exemple tout envoyer : ./lazy-git.sh . \"Mise à jour globale\""
    exit 1
fi

# Récupération des arguments
TARGETS=$1
COMMIT_MSG=$2

echo "🚀 Début de l'automatisation Git..."

# 1. Git Add
echo "📁 Ajout des fichiers : $TARGETS"
git add $TARGETS

# Vérification si le git add a fonctionné
if [ $? -ne 0 ]; then
    echo "❌ Erreur lors du 'git add'. Vérifie tes chemins."
    exit 1
fi

# 2. Git Commit
echo "📝 Création du commit : \"$COMMIT_MSG\""
git commit -m "$COMMIT_MSG"

# Vérification si le commit a fonctionné (ex: s'il n'y a rien à commit)
if [ $? -ne 0 ]; then
    echo "⚠️ Rien à commit ou erreur lors du commit."
    exit 1
fi

# 3. Git Push
echo "⬆️ Push en cours vers le dépôt distant..."
git push

if [ $? -eq 0 ]; then
    echo "✅ Tout est en ligne ! Beau boulot."
else
    echo "❌ Échec du push. Vérifie ta connexion ou s'il y a des conflits."
fi

