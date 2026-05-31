<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php
            require('../script/datas-traitment.php');
            if(viewSession()){
                header('Location:../profil/');
            }
        ?>
        <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Tracksida – Connexion / Inscription</title>
            <link rel="stylesheet" href="../css/auth.css" />
        </head>
    <body>
        <?php require('../module/header.php');?>

        <div class="auth-bg"></div>
    
        <div class="auth-page">
        
            <!-- Logo -->
            <div class="auth-brand">
            <a href="/" class="auth-logo">Tracksida</a>
            <span class="auth-tagline">Ton espace santé</span>
            </div>
        
            <!-- Card unique -->
            <div class="auth-card">
        
            <!-- Tabs toggle -->
            <div class="auth-tabs" role="tablist">
                <button class="auth-tab active" id="tab-login"    role="tab" aria-controls="panel-login"    aria-selected="true">Connexion</button>
                <button class="auth-tab"        id="tab-register" role="tab" aria-controls="panel-register" aria-selected="false">Inscription</button>
            </div>
        
            <div class="auth-panels">
        
                <!-- ══ PANEL CONNEXION ══ -->
                <div class="auth-panel active" id="panel-login" role="tabpanel">
        
                <form method="POST" action="connexion.php" id="loginForm" novalidate>
        
                    <!-- Email -->
                    <div class="form-group">
                    <label for="login-email">Adresse e-mail</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m2 7 10 7 10-7"/></svg>
                        </span>
                        <input type="email" id="login-email" name="email" placeholder="exemple@mail.com" autocomplete="email" required />
                    </div>
                    <span class="field-error" id="loginEmailErr">Adresse e-mail invalide.</span>
                    </div>
        
                    <!-- Mot de passe -->
                    <div class="form-group">
                    <label for="login-pwd">Mot de passe</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="login-pwd" name="password" placeholder="••••••••" autocomplete="current-password" required />
                        <button type="button" class="toggle-pwd" data-target="login-pwd" aria-label="Afficher">
                        <svg class="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <span class="field-error" id="loginPwdErr">Mot de passe requis.</span>
                    </div>
        
                    <!-- Options -->
                    <div class="form-options">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" value="1" />
                        Se souvenir de moi
                    </label>
                    <button type="button" class="forgot-link" onclick="window.location.href='/forgot-password'">
                        Mot de passe oublié ?
                    </button>
                    </div>
        
                    <button type="submit" class="btn-submit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Se connecter
                    </button>
        
                </form>
                </div>
        
                <!-- ══ PANEL INSCRIPTION ══ -->
                <div class="auth-panel" id="panel-register" role="tabpanel">
        
                <form method="POST" action="inscription.php" id="registerForm" novalidate>
        
                    <!-- Prénom / Nom -->
                    <div class="form-row">
                    <div class="form-group">
                        <label for="reg-prenom">Prénom</label>
                        <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input type="text" id="reg-prenom" name="prenom" placeholder="Jean" autocomplete="given-name" required />
                        </div>
                        <span class="field-error" id="regPrenomErr">Prénom requis.</span>
                    </div>
        
                    <div class="form-group">
                        <label for="reg-nom">Nom</label>
                        <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input type="text" id="reg-nom" name="nom" placeholder="Dupont" autocomplete="family-name" required />
                        </div>
                        <span class="field-error" id="regNomErr">Nom requis.</span>
                    </div>
                    </div>
        
                    <!-- Email -->
                    <div class="form-group">
                    <label for="reg-email">Adresse e-mail</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m2 7 10 7 10-7"/></svg>
                        </span>
                        <input type="email" id="reg-email" name="email" placeholder="exemple@mail.com" autocomplete="email" required />
                    </div>
                    <span class="field-error" id="regEmailErr">Adresse e-mail invalide.</span>
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                    <label for="reg-gender">Gender</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m2 7 10 7 10-7"/></svg>
                        </span>
                        <input type="text" id="reg-gender" name="gender" placeholder="homme/femme/non-binaire" autocomplete="non-défini" required />
                    </div>
                    <span class="field-error" id="regGenderErr">Adresse e-mail invalide.</span>
                    </div>

                    <!-- Téléphone -->
                    <div class="form-group">
                    <label for="reg-phone">Téléphone</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.42 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.34 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.4a16 16 0 0 0 6.29 6.29l1.76-1.76a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <input type="tel" id="reg-phone" name="telephone" placeholder="+33 6 00 00 00 00" autocomplete="tel" required />
                    </div>
                    <span class="field-error" id="regPhoneErr">Numéro de téléphone invalide.</span>
                    </div>

                    <!-- Date de naissance -->
                    <div class="form-group">
                    <label for="reg-dob">Date de naissance</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                        <input type="date" id="reg-dob" name="date_naissance" autocomplete="bday" required />
                    </div>
                    <span class="field-error" id="regDobErr">Date de naissance requise.</span>
                    </div>

                    <!-- Ville -->
                    <div class="form-group">
                    <label for="reg-ville">Ville</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        </span>
                        <input type="text" id="reg-ville" name="ville" placeholder="Paris" autocomplete="address-level2" required />
                    </div>
                    <span class="field-error" id="regVilleErr">Ville requise.</span>
                    </div>
                            
                    <!-- Mot de passe -->
                    <div class="form-group">
                    <label for="reg-pwd">Mot de passe</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="reg-pwd" name="password" placeholder="8 caractères minimum" autocomplete="new-password" required />
                        <button type="button" class="toggle-pwd" data-target="reg-pwd" aria-label="Afficher">
                        <svg class="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="pwd-strength">
                        <div class="pwd-bar" id="bar1"></div>
                        <div class="pwd-bar" id="bar2"></div>
                        <div class="pwd-bar" id="bar3"></div>
                        <div class="pwd-bar" id="bar4"></div>
                    </div>
                    <span class="pwd-hint" id="pwdHint">Minimum 8 caractères</span>
                    <span class="field-error" id="regPwdErr">Minimum 8 caractères.</span>
                    </div>
        
                    <!-- Confirmation -->
                    <div class="form-group">
                    <label for="reg-pwd-confirm">Confirmer le mot de passe</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="reg-pwd-confirm" name="password_confirm" placeholder="••••••••" autocomplete="new-password" required />
                        <button type="button" class="toggle-pwd" data-target="reg-pwd-confirm" aria-label="Afficher">
                        <svg class="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <span class="field-error" id="regConfirmErr">Les mots de passe ne correspondent pas.</span>
                    </div>
        
                    <!-- CGU -->
                    <div class="cgu-row">
                    <input type="checkbox" id="reg-cgu" name="cgu" value="1" required />
                    <label for="reg-cgu">
                        J'accepte les <a href="/cgu">CGU</a> et la <a href="/confidentialite">Politique de confidentialité</a>
                    </label>
                    </div>
                    <span class="field-error" id="regCguErr">Vous devez accepter les CGU.</span>
        
                    <button type="submit" class="btn-submit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Créer mon compte
                    </button>
        
                </form>
                </div>
        
            </div>
            </div>
        
        </div>


        <?php require('../module/footer.php');?>

        <script src="../js/auth.js"></script>

    </body>
</html>