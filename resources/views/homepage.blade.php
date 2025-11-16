<x-app-layout title="Accueil | Demande d'Intervention">

    <!-- Conteneur principal avec background sur toute la page -->
    <div class="flex flex-col min-h-screen" style="background-color:#f9eddd; color:#442b1f;">

        <!-- CONTENU PRINCIPAL -->
        <div class="flex-grow mx-[5%] pt-10">

            <!-- SECTION : QUI SOMMES-NOUS ? -->
            <div id="presentation" class="p-10 mb-16 bg-white shadow-xl rounded-xl">
                <h2 class="pb-3 mb-8 text-3xl font-bold border-b" style="border-color:#442b1f;">
                    Qui sommes-nous ?
                </h2>

                <div class="flex flex-col items-center gap-12 md:flex-row md:items-start">

                    <!-- IMAGE À GAUCHE -->
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/Atelier404.png') }}"
                             alt="Atelier 404"
                             class="rounded-lg shadow-md max-w-[420px] ml-8">
                    </div>

                    <!-- TEXTE À DROITE -->
                    <div class="flex-1">
                        <h3 class="mb-4 text-2xl font-semibold">
                            Votre expert en réparation d'appareils électroniques
                        </h3>

                        <p class="mb-6 text-lg leading-relaxed">
                            Bienvenue à l'Atelier 404. Nous sommes spécialisés dans
                            le diagnostic et la réparation de tous types d'appareils
                            électroniques. Nous mettons notre expertise et notre passion
                            au service de vos appareils pour leur donner une seconde vie.
                        </p>

                        <h4 class="mt-6 mb-2 text-xl font-semibold">🕰️ Horaires d'ouverture :</h4>
                        <ul class="ml-4 text-lg list-disc list-inside">
                            <li>Lundi - Vendredi : 9h00 - 18h00</li>
                            <li>Samedi : 10h00 - 16h00</li>
                        </ul>

                        <h4 class="mt-6 mb-2 text-xl font-semibold">🔧 Services Principaux :</h4>
                        <ul class="ml-4 text-lg list-disc list-inside">
                            <li>Réparation d'écrans</li>
                            <li>Diagnostic de pannes</li>
                            <li>Récupération de données</li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- SECTION : FORMULAIRE -->
            <div id="contact" class="p-10 mb-16 bg-white shadow-xl rounded-xl">

                @if (session('success'))
                    <div class="p-4 mb-6 rounded-lg" style="background:#d1f5d3; color:#155724;">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="pb-3 mb-8 text-3xl font-bold border-b" style="border-color:#442b1f;">
                    Formulaire de Contact et Demande d'Intervention
                </h2>

                <form action="{{ route('interventions.store') }}"
                      method="POST"
                      class="space-y-6"
                      enctype="multipart/form-data"
                      id="intervention-form">

                    @csrf

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="nom" class="block text-sm font-medium">Nom et Prénom</label>
                            <input type="text" name="nom" id="nom" required
                                   class="block w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium">Adresse Email</label>
                            <input type="email" name="email" id="email" required
                                   class="block w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="telephone" class="block text-sm font-medium">Téléphone</label>
                            <input type="tel" name="telephone" id="telephone"
                                   class="block w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="appareil" class="block text-sm font-medium">Type d'Appareil</label>
                            <select id="appareil" name="appareil" required
                                    class="block w-full p-3 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionnez un type</option>
                                <option value="smartphone">Smartphone</option>
                                <option value="ordinateur">Ordinateur (PC/Mac)</option>
                                <option value="tablette">Tablette</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="description_probleme" class="block text-sm font-medium">Description Détaillée du Problème</label>
                        <textarea name="description_probleme" id="description_probleme" rows="4" required
                                  class="block w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Décrivez en détail la panne, le dommage ou le service souhaité..."></textarea>
                    </div>

                    <!-- DRAG & DROP IMAGES -->
                    <div>
                        <label class="block text-sm font-medium">
                            Ajouter des images (max 3) - Glisser / déposer ou cliquer
                        </label>

                        <div id="drop-zone"
                             class="w-full p-4 mt-1 text-center border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-indigo-500">
                            Glissez vos images ici ou cliquez pour sélectionner
                            <input type="file" id="images" accept="image/*" multiple class="hidden">
                        </div>

                        <div id="image-previews" class="flex flex-wrap gap-4 mt-4"></div>
                    </div>

                    <!-- BOUTON -->
                    <div>
                        <button type="submit"
                                class="px-4 py-2 bg-[#442b1f] text-[#d0ba9b] font-semibold rounded hover:opacity-90 w-full text-center">
                            Envoyer la Demande et Créer l'Intervention
                        </button>
                    </div>

                </form>
            </div>

        </div> <!-- FIN CONTENU PRINCIPAL -->


    </div>

    <!-- SCRIPT DRAG & DROP -->
    <script>
        let selectedFiles = [];
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('images');
        const previewsContainer = document.getElementById('image-previews');
        const form = document.getElementById('intervention-form');

        dropZone.addEventListener('click', () => fileInput.click());
        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-gray-50'); });
        dropZone.addEventListener('dragleave', e => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-gray-50'); });
        dropZone.addEventListener('drop', e => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-gray-50'); handleFiles(Array.from(e.dataTransfer.files)); });
        fileInput.addEventListener('change', e => { handleFiles(Array.from(e.target.files)); fileInput.value=''; });

        function handleFiles(files) {
            files.forEach(file => {
                if (selectedFiles.length >= 3) { alert("Vous ne pouvez sélectionner que 3 images maximum."); return; }
                if (!file.type.startsWith('image/')) return;
                selectedFiles.push(file);
            });
            updatePreviews();
        }

        function updatePreviews() {
            previewsContainer.innerHTML='';
            selectedFiles.forEach((file,index)=>{
                const reader=new FileReader();
                reader.onload=function(e){
                    const wrapper=document.createElement('div'); wrapper.classList.add('relative');
                    const img=document.createElement('img'); img.src=e.target.result; img.style.maxWidth='150px'; img.style.maxHeight='150px'; img.classList.add('rounded','shadow');
                    const removeBtn=document.createElement('button'); removeBtn.type='button'; removeBtn.innerHTML='×';
                    removeBtn.classList.add('absolute','top-0','right-0','bg-red-600','text-white','rounded-full','w-6','h-6','flex','items-center','justify-center');
                    removeBtn.onclick=()=>{ selectedFiles.splice(index,1); updatePreviews(); };
                    wrapper.appendChild(img); wrapper.appendChild(removeBtn); previewsContainer.appendChild(wrapper);
                }
                reader.readAsDataURL(file);
            });
        }

        form.addEventListener('submit', function(e){
            selectedFiles.forEach(file=>{
                const hiddenInput=document.createElement('input');
                hiddenInput.type='file'; hiddenInput.name='images[]'; hiddenInput.files=createFileList(file); hiddenInput.style.display='none'; form.appendChild(hiddenInput);
            });
        });

        function createFileList(file){ const dataTransfer=new DataTransfer(); dataTransfer.items.add(file); return dataTransfer.files; }
    </script>

</x-app-layout>

