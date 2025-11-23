// Import React
import { useState } from 'react';
// Import router dari Inertia
import { router } from '@inertiajs/react';
export default function Create() {
    // State untuk menyimpan nilai input dari form
    // form = { nama: '', tempat_lahir: '', tanggal_lahir: '' }
    const [form, setForm] = useState({
        nama: '',
        tempat_lahir: '',
        tanggal_lahir: '',
    });
    // Fungsi yang dijalankan saat form disubmit
    const handleSubmit = (e) => {
        e.preventDefault(); // Mencegah reload halaman
        // Kirim data ke endpoint /biodata dengan metode POST
        router.post('/biodata', form);
    };
    return (
        <div className="container mt-4">
            <h2>Tambah Biodata</h2>
            {/* Form input data*/}
            <form onSubmit={handleSubmit}>
                {/* Input untuk Nama */}
                <div className="mb-3">
                    <label>Nama</label>
                    <input
                        className="form-control"
                        value={form.nama}
                        onChange={(e) =>
                            setForm({ ...form, nama: e.target.value })
                        }
                        required
                    />
                </div>
                {/* Input untuk Tempat Lahir */}
                <div className="mb-3">
                    <label>Tempat Lahir</label>
                    <input
                        className="form-control"
                        value={form.tempat_lahir}
                        onChange={(e) =>
                            setForm({ ...form, tempat_lahir: e.target.value })
                        }
                        required
                    />
                </div>
                {/* Input untuk Tanggal Lahir */}
                <div className="mb-3">
                    <label>Tanggal Lahir</label>
                    <input
                        type="date"
                        className="form-control"
                        value={form.tanggal_lahir}
                        onChange={(e) =>
                            setForm({ ...form, tanggal_lahir: e.target.value })
                        }
                        required
                    />
                </div>
                {/* Tombol submit */}
                <button className="btn btn-primary">Simpan</button>
            </form>
        </div>
    );
}
