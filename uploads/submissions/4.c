#include <stdio.h>
#include <string.h> // Include string.h for the strchr function

typedef struct
{
    char nama[100];
    int nilaitugas;
    int nilaiuts;
    int nilaiuas;
} Mahasiswa;

typedef struct
{
    int nilaiakhir;
    char grade;
} Hasil;

typedef struct
{
    char nama[100];
    int nilaiakhir;
} Winner;

Hasil hitunghasil(int tugas, int uts, int uas)
{
    Hasil perhitungan;

    int rata = ((tugas * 0.2) + (0.4 * (uts + uas)));
    perhitungan.nilaiakhir = rata;
    if (rata >= 80)
    {
        perhitungan.grade = 'A';
    }
    else if (rata >= 70)
    {
        perhitungan.grade = 'B';
    }
    else if (rata >= 60)
    {
        perhitungan.grade = 'C';
    }
    else if (rata >= 50)
    {
        perhitungan.grade = 'D';
    }
    else
    {
        perhitungan.grade = 'E';
    }
    return perhitungan;
}
void input(Mahasiswa *mahasiswa, int jumlah)
{
    for (int i = 0; i < jumlah; i++)
    {
        printf("\nMahasiswa ke-%d", i + 1);

        printf("\nNama: ");
        scanf("%s", &mahasiswa[i].nama);

        printf("Nilai tugas: ");
        scanf("%d", &mahasiswa[i].nilaitugas);
        printf("Nilai uts: ");
        scanf("%d", &mahasiswa[i].nilaiuts);
        printf("Nilai uas: ");
        scanf("%d", &mahasiswa[i].nilaiuas);
        getchar(); 
    }
}

void tampil(Mahasiswa *mahasiswa, int jumlah)
{
    Winner king;
    king.nilaiakhir = 0;
    int i;
    printf("---------------------------------------------------------------\n");
    for (i = 0; i < jumlah; i++)
    {
        Hasil grade = hitunghasil(
            mahasiswa[i].nilaitugas,
            mahasiswa[i].nilaiuts,
            mahasiswa[i].nilaiuas);
        printf("%d\t%s\t%d\t%d\t%d\t%d\t%c\n",
               i + 1,
               mahasiswa[i].nama,
               mahasiswa[i].nilaitugas,
               mahasiswa[i].nilaiuts,
               mahasiswa[i].nilaiuas,
               grade.nilaiakhir,
               grade.grade);
        if (grade.nilaiakhir > king.nilaiakhir)
        {

            king.nilaiakhir = grade.nilaiakhir;
            strcpy(king.nama, mahasiswa[i].nama);
        }
    }
    printf("----------------------------------------------------------------\n");
    printf("\nTotal Mahasiswa = %d \n", i);
    printf("\nNilai Tertinggi");
    printf("\nNama           : %s", king.nama);
    printf("\nNilai          : %d", king.nilaiakhir);
    printf("\n\n");
}

int main()
{
    int jumlah, i;
    printf("Berapa jumlah mahasiswa: ");
    scanf("%d", &jumlah);
    getchar();

    Mahasiswa mahasiswa[jumlah];
    printf("\nMasukkan Data Mahasiswa\n");

    input(mahasiswa, jumlah);

    printf("\nNo\tNama\t\tTugas\tUTS\tUAS\tAkhir\tgrade\n");
    tampil(mahasiswa, jumlah);

    return 0;
}
