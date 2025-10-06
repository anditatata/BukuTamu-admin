@extends('layouts.app')

@section('title', 'Tambah Instansi')
@section('page-title', 'Tambah Data Instansi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-8">Form Tambah Tamu</h2>
           
            @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <form method="POST" action="{{ route('instansi.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Orang Tua -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nama" 
                               placeholder="Masukkan nama lengkap"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                    </div>

                    <!-- Asal Instansi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Asal Instansi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="instansi_asal" 
                               placeholder="Masukkan asal instansi"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Keperluan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keperluan" 
                                  rows="3"
                                  placeholder="Jelaskan keperluan kunjungan Anda"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                  required></textarea>
                    </div>
                        <!-- Kontak -->
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kontak <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="kontak" 
                               placeholder="Masukkan nomor telepon"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                    </div>

                           <div>
  <label for="guru" class="block text-sm font-medium text-gray-700 mb-2">
    Guru yang Dituju
  </label>
  <select id="guru" name="guru" 
          class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    <option value="">-- Pilih Guru --</option>
       <option value="A.R Fauzan, S.Ip. M.M">A.R Fauzan, S.Ip. M.M</option>
            <option value="Ade Hartono, S.Pd">Ade Hartono, S.Pd</option>
            <option value="Ade Rahmat Nugraha">Ade Rahmat Nugraha</option>
            <option value="Adiwiguna, S.Pd">Adiwiguna, S.Pd</option>
            <option value="Ahmad Saripuloh">Ahmad Saripuloh</option>
            <option value="Anggita Septiani, S.T.P, M.Pd">Anggita Septiani, S.T.P, M.Pd</option>
            <option value="Annisa Intikarusdiansari, S.Pd.">Annisa Intikarusdiansari, S.Pd.</option>
            <option value="Apriliani Hardiyanti Hariyono, S.Pd">Apriliani Hardiyanti Hariyono, S.Pd</option>
            <option value="Ariantonius Sagala, S.Kom">Ariantonius Sagala, S.Kom</option>
            <option value="Asep Saleh, S.E">Asep Saleh, S.E</option>
            <option value="Atep Aulia Rahman, S.T. M.Kom">Atep Aulia Rahman, S.T. M.Kom</option>
            <option value="Cecep Suryana, S.Si">Cecep Suryana, S.Si</option>
            <option value="Dadan Rukma">Dadan Rukma</option>
            <option value="Dian Dawan, S.Pd">Dian Dawan, S.Pd</option>
            <option value="Danty, S.Pd.">Danty, S.Pd.</option>
            <option value="Dede Saepudin, S.Pd">Dede Saepudin, S.Pd</option>
            <option value="Dedi Efendi, S.Kom">Dedi Efendi, S.Kom</option>
            <option value="Dedi Jaenudin">Dedi Jaenudin</option>
            <option value="Dena Handriana, M.Pd">Dena Handriana, M.Pd</option>
            <option value="Desta Mulyanti, S.Sn">Desta Mulyanti, S.Sn</option>
            <option value="Dicky Zulkarnaen">Dicky Zulkarnaen</option>
            <option value="Dini Karomna, S.Pd">Dini Karomna, S.Pd</option>
            <option value="Dr. Ermawati, M.Kom">Dr. Ermawati, M.Kom</option>
            <option value="Dr. Hj. Yani Heryani, M.M.Pd">Dr. Hj. Yani Heryani, M.M.Pd</option>
            <option value="Dr. Sudarmi, M.Pd">Dr. Sudarmi, M.Pd</option>
            <option value="Dra. Mimy Ardiany, M.Pd">Dra. Mimy Ardiany, M.Pd</option>
            <option value="Dra. Rahmi Dalilah Fitrianni">Dra. Rahmi Dalilah Fitrianni</option>
            <option value="Dra. Weni Asmaraeni">Dra. Weni Asmaraeni</option>
            <option value="Ela Nurlaela, S.Pd">Ela Nurlaela, S.Pd</option>
            <option value="Endah Permatasari">Endah Permatasari</option>
            <option value="Endang Misnam">Endang Misnam</option>
            <option value="Endang Sunandar, S.Pd., M.Pkim">Endang Sunandar, S.Pd., M.Pkim</option>
            <option value="Eti Ariesanti, S.Pd">Eti Ariesanti, S.Pd</option>
            <option value="Eva Zulva, S.Kom,I">Eva Zulva, S.Kom,I</option>
            <option value="Fahira Armi Ramadhani, S.T">Fahira Armi Ramadhani, S.T</option>
            <option value="Fertika, S.Pd">Fertika, S.Pd</option>
            <option value="Gina Urfah Mastur Sadili, S.Pd.">Gina Urfah Mastur Sadili, S.Pd.</option>
            <option value="Halida Farhani, S.Psi">Halida Farhani, S.Psi</option>
            <option value="Hasan As'ari, M.Kom">Hasan As'ari, M.Kom</option>
            <option value="Hazar Nurbani, M.Pd">Hazar Nurbani, M.Pd</option>
            <option value="Hendra">Hendra</option>
            <option value="Heni Juhaeni, S.Pd">Heni Juhaeni, S.Pd</option>
            <option value="Iah Robiah, S.Pd. Kim.">Iah Robiah, S.Pd. Kim.</option>
            <option value="Ina Marina, S.T">Ina Marina, S.T</option>
            <option value="Indira Sari Paputungan, M.Ed. Gr">Indira Sari Paputungan, M.Ed. Gr</option>
            <option value="Indra Adiguna, S.T">Indra Adiguna, S.T</option>
            <option value="Iwan Setiawan">Iwan Setiawan</option>
            <option value="Jaya Sumpena, M.Kom">Jaya Sumpena, M.Kom</option>
            <option value="Kania Dewi Waluya, S.S.T">Kania Dewi Waluya, S.S.T</option>
            <option value="Kiki Aima Mu'mina, S.Pd">Kiki Aima Mu'mina, S.Pd</option>
            <option value="Lia Yulianti, M.Pd">Lia Yulianti, M.Pd</option>
            <option value="Maspuri Andewi, S.Kom">Maspuri Andewi, S.Kom</option>
            <option value="Maya Kusmayanti, M.Pd">Maya Kusmayanti, M.Pd</option>
            <option value="Meli Novita, M.M.Pd">Meli Novita, M.M.Pd</option>
            <option value="Mira Apriyani">Mira Apriyani</option>
            <option value="Muchamad Harry Ismail, S.T.R.Kom, M.M">Muchamad Harry Ismail, S.T.R.Kom, M.M</option>
            <option value="Nadia Afriliani, S.Pd">Nadia Afriliani, S.Pd</option>
            <option value="Neneng Suhartini, S.Si, S.Pd. Gr">Neneng Suhartini, S.Si, S.Pd. Gr</option>
            <option value="Nina Dewi Koswara, S.Pd">Nina Dewi Koswara, S.Pd</option>
            <option value="Nofa Nirawati, S.Pd, M.T">Nofa Nirawati, S.Pd, M.T</option>
            <option value="Nogi Muharam, S.Kom.">Nogi Muharam, S.Kom.</option>
            <option value="Nur Fauziyah Rahmawati, S.Pd">Nur Fauziyah Rahmawati, S.Pd</option>
            <option value="Nurlaela, Sh">Nurlaela, Sh</option>
            <option value="Nurul Diningsih, S.Hum">Nurul Diningsih, S.Hum</option>
            <option value="Octavina Sopamena, M.Pd">Octavina Sopamena, M.Pd</option>
            <option value="Odang Supriatna, S.E.">Odang Supriatna, S.E.</option>
            <option value="Oman Somana, M.Pd">Oman Somana, M.Pd</option>
            <option value="Popong Wariati, S.Pd">Popong Wariati, S.Pd</option>
            <option value="Pratiwi, S.S.I">Pratiwi, S.S.I</option>
            <option value="Priyo Hadisuryo, S.S.T">Priyo Hadisuryo, S.S.T</option>
            <option value="Rakiman">Rakiman</option>
            <option value="Rani Rabiussani, M.Pd">Rani Rabiussani, M.Pd</option>
            <option value="Regina Fitrie, S.Pd">Regina Fitrie, S.Pd</option>
            <option value="Ricky Valentine">Ricky Valentine</option>
            <option value="Rina Daryani, M.Pd">Rina Daryani, M.Pd</option>
            <option value="Rini Dwiwahyuni, S.Pd">Rini Dwiwahyuni, S.Pd</option>
            <option value="Riska Fitriyanti, A.Md">Riska Fitriyanti, A.Md</option>
            <option value="Rita Hartati, S.Pd, M.T">Rita Hartati, S.Pd, M.T</option>
            <option value="Roby Ismail Adi Putra, S.A.P">Roby Ismail Adi Putra, S.A.P</option>
            <option value="Ruhya, S.Ag, M.M.Pd">Ruhya, S.Ag, M.M.Pd</option>
            <option value="Rukmana, S.Pd.I">Rukmana, S.Pd.I</option>
            <option value="Sabila Fauziyya, S.Kom">Sabila Fauziyya, S.Kom</option>
            <option value="Safitri Insani, S.T.P">Safitri Insani, S.T.P</option>
            <option value="Samsudin, S.Ag">Samsudin, S.Ag</option>
            <option value="Santika, M.Pd">Santika, M.Pd</option>
            <option value="Sarinah Br Ginting, M.Pd">Sarinah Br Ginting, M.Pd</option>
            <option value="Shendy Antariksa, S.Hum">Shendy Antariksa, S.Hum</option>
            <option value="Sugiyatmi, S.Si">Sugiyatmi, S.Si</option>
            <option value="Sukmawidi, S.Pd">Sukmawidi, S.Pd</option>
            <option value="Syafitri Kurniati Arief, S.Pd, M.T">Syafitri Kurniati Arief, S.Pd, M.T</option>
            <option value="Taufik Hidayat, M.Pd">Taufik Hidayat, M.Pd</option>
            <option value="Tessa Eka Yuniar, S.Pd">Tessa Eka Yuniar, S.Pd</option>
            <option value="Tini Rosmayani, S.Si">Tini Rosmayani, S.Si</option>
            <option value="Tita Heriyanti, S.Pd">Tita Heriyanti, S.Pd</option>
            <option value="Tita Lismayanti, S.Pd">Tita Lismayanti, S.Pd</option>
            <option value="Tiyas Rizkia, S.Li.">Tiyas Rizkia, S.Li.</option>
            <option value="Tubagus Saputra, M.Pd">Tubagus Saputra, M.Pd</option>
            <option value="Ujang Suhara, S.Pd">Ujang Suhara, S.Pd</option>
            <option value="Uli Solihat Kamaluddin, S.Si, Gr">Uli Solihat Kamaluddin, S.Si, Gr</option>
            <option value="Wanto Kurniawan">Wanto Kurniawan</option>
          
            <option value="Windy Novia Anggraeni, S.Si">Windy Novia Anggraeni, S.Si</option>
            <option value="Yeni Meilina, S.Pd">Yeni Meilina, S.Pd</option>
            <option value="Zaka Faishal Hadiyan S, Kom">Zaka Faishal Hadiyan S, Kom</option>
  </select>
</div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Peserta <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="jumlah_peserta" 
                               placeholder="Contoh: 1 orang, 10 orang"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                    </div>
                
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="time" 
                               name="waktu_kunjungan" 
                               value="{{ date('H:i') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_kunjungan" 
                               value="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                    </div>
                    <!-- Foto -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Foto
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="foto" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="foto" type="file" name="foto" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <div id="preview-container" class="mt-4 hidden">
                            <div class="relative inline-block">
                                <img id="image-preview" src="" alt="Preview" class="w-24 h-24 object-cover rounded-lg border border-gray-300">
                                <button type="button" id="remove-image" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('instansi.index') }}" 
                       class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('remove-image').addEventListener('click', function() {
    document.getElementById('foto').value = '';
    document.getElementById('preview-container').classList.add('hidden');
});
</script>
@endsection