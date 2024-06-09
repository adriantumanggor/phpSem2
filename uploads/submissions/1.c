#include <stdio.h>
#include <string.h> // Include string.h for the strchr function

struct Mahasiswa
{
    char nama[100];
    int nilaitugas;
    int nilaiuts;
    int nilaiuas;
};

struct Hasil
{
    int nilaiakhir;
    char grade;
};
struct Hasil hitunghasil(int tugas, int uts, int uas)
{
    struct Hasil perhitungan;

    int rata = ((tugas* 0.2) + (0.4*(uts + uas)));
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
void input(struct Mahasiswa *mahasiswa)
{
    printf("\nNama: ");
    fgets((*mahasiswa).nama, sizeof((*mahasiswa).nama), stdin);

    // Remove newline character if present
    char *newline = strchr((*mahasiswa) .nama, '\n');
    if (newline != NULL)
        *newline = '\0';

    printf("Nilai tugas: ");
    scanf("%d", &(*mahasiswa).nilaitugas);
    printf("Nilai uts: ");
    scanf("%d", &(*mahasiswa).nilaiuts);
    printf("Nilai uas: ");
    scanf("%d", &(*mahasiswa).nilaiuas);
    getchar(); // Consume the newline character left in the input buffer
}


void tampil(struct Mahasiswa *mahasiswa, int no)
{

    struct Hasil grade = hitunghasil(
                mahasiswa->nilaitugas,
                mahasiswa->nilaiuts, 
                mahasiswa->nilaiuas
                );
    printf("%d\t%s\t%d\t%d\t%d\t%d\t%c\n",
            no, 
            mahasiswa->nama, 
            mahasiswa->nilaitugas, 
            mahasiswa->nilaiuts, 
            mahasiswa->nilaiuas, 
            grade.nilaiakhir,
            grade.grade 
            );
}

int main()
{
    int jumlah;
    printf("Berapa jumlah mahasiswa: ");
    scanf("%d", &jumlah);
    getchar();      

    struct Mahasiswa mahasiswa[jumlah];
    printf("\nMasukkan Data Mahasiswa\n");

    for (int i = 0; i < jumlah; i++)
    {
        printf("\nMahasiswa ke-%d", i + 1);
        input(&(mahasiswa[i]));
    }

    printf("\nNo\tNama\t\tTugas\tUTS\tUAS\tAkhir\tgrade\n");
    printf("---------------------------------------------------------------\n");
    for (int i = 0; i < jumlah; i++)
    {
        tampil(&(mahasiswa[i]), i + 1);
    }
    printf("---------------------------------------------------------------\n");

    return 0;
}
