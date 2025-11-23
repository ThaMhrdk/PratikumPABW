// Import React
import { useState } from 'react';
// Import router
import { router, usePage } from '@inertiajs/react';
export default function Edit() {
    // Ambil data biodata
    const { biodata } = usePage().props;
    // Buat state form awal berdasarkan data biodata yang diterima
    const [form, setForm] = useState({ ...biodata });
    // Fungsi untuk meng-handle saat form disubmit
    const handleSubmit = (e) => {
        e.preventDefault(); // Mencegah reload halaman
        // Kirim data yang diperbarui ke server via metode PUT
        router.put(`/biodata/${biodata.id}`, form);
    };
    return (
        <div className="container mt-4">
            <h2>Edit Biodata</h2>
            {/* Form edit*/}
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
                {/* Tombol update */}
                <button className="btn btn-success">Update</button>
            </form>
        </div>
    );
}
