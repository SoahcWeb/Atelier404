<footer class="bg-[#d0ba9b] text-[#442b1f] py-10 mt-auto">
    <div class="grid grid-cols-1 gap-6 px-4 mx-auto text-center max-w-7xl md:grid-cols-3">

        <!-- 1️⃣ Informations de contact -->
        <div class="md:pr-4 md:border-r md:border-[#442b1f] flex flex-col items-center">
            <h4 class="font-bold italic mb-2 text-xl border-b-2 border-[#442b1f] pb-1 inline-block">Contact</h4>
            <p>Atelier 404 – Repair Café Étudiant</p>
            <p><span class="font-semibold">Adresse :</span> 45 Rue des Étudiants, 1000 Ville</p>
            <p><span class="font-semibold">Téléphone :</span> 01 23 45 67 89</p>
            <p><span class="font-semibold">Email :</span>
                <a href="mailto:contact@atelier404.edu" class="underline text-[#442b1f]">contact@atelier404.edu</a>
            </p>
        </div>

        <!-- 2️⃣ Liens rapides + réseaux sociaux -->
        <div class="md:px-4 md:border-r md:border-[#442b1f] mt-6 md:mt-0 flex flex-col items-center">
            <h4 class="font-bold italic mb-2 text-xl border-b-2 border-[#442b1f] pb-1 inline-block">Liens utiles</h4>
            <ul class="mb-4">
                <li><a href="{{ route('faq') }}" class="underline text-[#442b1f]">FAQ / Aide</a></li>
            </ul>

            <!-- Réseaux sociaux sous la FAQ -->
            <div class="flex justify-center gap-2 mt-2">
                <a href="#"><img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-6 h-6"></a>
                <a href="#"><img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-6 h-6"></a>
                <a href="#"><img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" class="w-6 h-6"></a>
                <a href="#"><img src="{{ asset('images/discord.png') }}" alt="Discord" class="w-6 h-6"></a>
            </div>
        </div>

        <!-- 3️⃣ À propos -->
        <div class="flex flex-col items-center mt-6 md:pl-4 md:mt-0">
            <h4 class="font-bold italic mb-2 text-xl border-b-2 border-[#442b1f] pb-1 inline-block">À propos</h4>
            <p>Projet réalisé par <span class="font-semibold">Jesus Roldan et Jonathan Pauwels</span></p>
            <p>© 2025 Atelier 404</p>
            <p><a href="https://github.com/SoahcWeb/Atelier404.git" target="_blank" class="underline text-[#442b1f]">Voir le dépôt GitHub</a></p>
        </div>

    </div>
</footer>
