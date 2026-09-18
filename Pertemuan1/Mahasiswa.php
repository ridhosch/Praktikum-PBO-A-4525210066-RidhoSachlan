<?php
declare(strict_types=1);

/**
 * Sesi 2 — enkapsulasi yang menjaga invariant (PHP).
 * Bandingkan baris demi baris dengan java/Mahasiswa.java.
 */
class Mahasiswa
{
    public const float BOBOT_TUGAS = 0.30;
    public const float BOBOT_UTS   = 0.30;
    public const float BOBOT_UAS   = 0.40;

    private const float NILAI_MIN = 0;
    private const float NILAI_MAX = 100;

    /**
     * Constructor property promotion (PHP 8):
     * readonly adalah padanan `final` pada atribut Java.
     *
     * TODO 1: lengkapi daftar parameter — tentukan mana yang readonly.
     */
        public function __construct(
        private readonly string $nim,
        private readonly string $nama,
        private float $nilaiTugas,
        private float $nilaiUts,
        private float $nilaiUas,
    ) {
        // TODO 2: tolak NIM yang kosong (setelah di-trim).
        if (trim($nim) === '') {
            throw new InvalidArgumentException('NIM tidak boleh kosong.');
        }

        // TODO 3: tolak setiap komponen nilai di luar rentang 0-100
        self::pastikanNilaiSah('nilaiTugas', $nilaiTugas);
        self::pastikanNilaiSah('nilaiUts', $nilaiUts);
        self::pastikanNilaiSah('nilaiUas', $nilaiUas);
    }

    /**
     * TODO 4: lengkapi validasi satu komponen nilai.
     */
    private static function pastikanNilaiSah(string $namaKomponen, float $nilai): void
    {
        if ($nilai < self::NILAI_MIN || $nilai > self::NILAI_MAX) {
            throw new InvalidArgumentException(sprintf(
                '%s harus berada pada rentang %.0f-%.0f, diterima: %.2f',
                $namaKomponen, self::NILAI_MIN, self::NILAI_MAX, $nilai
            ));
        }
    }

    /** TODO 5: hitung nilai akhir memakai konstanta bobot. */
    public function nilaiAkhir(): float
    {
        return $this->nilaiTugas * self::BOBOT_TUGAS
             + $this->nilaiUts   * self::BOBOT_UTS
             + $this->nilaiUas   * self::BOBOT_UAS;
    }

    /** TODO 6: kembalikan huruf mutu. Petunjuk: match (true) { ... } */
    public function hurufMutu(): string
    {
        $akhir = $this->nilaiAkhir();

        return match (true) {
            $akhir >= 85 => 'A',
            $akhir >= 75 => 'B',
            $akhir >= 60 => 'C',
            $akhir >= 45 => 'D',
            default      => 'E',
        };
    }

    // TODO 7: sediakan getter seperlunya. JANGAN membuat setNim().
    public function getNim(): string  { return $this->nim; }
    public function getNama(): string { return $this->nama; }
    public function getNilaiTugas(): float { return $this->nilaiTugas; }
    public function getNilaiUts(): float   { return $this->nilaiUts; }
    public function getNilaiUas(): float   { return $this->nilaiUas; }

    public function __toString(): string
    {
        return sprintf('%-10s %-18s akhir=%6.2f  mutu=%s',
            $this->nim, $this->nama, $this->nilaiAkhir(), $this->hurufMutu());
    }
}