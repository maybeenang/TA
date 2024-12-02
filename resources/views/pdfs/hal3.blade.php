<div class="mt-4 space-y-4 text-xs">
    <section class="space-y-2">
        <h2 class="text-sm">7. Evaluasi Diri Perkuliahan</h2>

        <p>
            {{ $laporan->self_evaluation ?? '-' }}
        </p>

        <table class="w-full table-auto border-collapse border border-black">
            <thead>
                <tr>
                    <th rowspan="2" class="w-10 border border-black text-center">No</th>
                    <th rowspan="2" class="border border-black text-center">Komponen Penilaian</th>
                    <th colspan="4" class="border border-black text-center">Persentase Ketercapaian</th>
                </tr>
                <tr>
                    <th class="border border-black text-center">Sangat Setuju</th>
                    <th class="border border-black text-center">Setuju</th>
                    <th class="border border-black text-center">Tidak Setuju</th>
                    <th class="border border-black text-center">Sangat Tidak Setuju</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan->quistionnaires as $row)
                    <tr>
                        <td class="border border-black text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="border border-black">{{ $row->statement }}</td>
                        <td class="border border-black text-center">{{ $row->strongly_agree }}%</td>
                        <td class="border border-black text-center">{{ $row->agree }}%</td>
                        <td class="border border-black text-center">{{ $row->disagree }}%</td>
                        <td class="border border-black text-center">{{ $row->strongly_disagree }}%</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="2" class="border border-black text-center font-medium">Rata-rata</td>

                    <td class="border border-black text-center font-medium">
                        @round($laporan->quistionnaires->avg('strongly_agree'))
                        %
                    </td>
                    <td class="border border-black text-center font-medium">
                        @round($laporan->quistionnaires->avg('agree'))
                        %
                    </td>
                    <td class="border border-black text-center font-medium">
                        @round($laporan->quistionnaires->avg('disagree'))
                        %
                    </td>
                    <td class="border border-black text-center font-medium">
                        @round($laporan->quistionnaires->avg('strongly_disagree'))
                        %
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <section class="space-y-2">
        <h2 class="text-sm">8. Tindak Lanjut pengembangan MK</h2>

        <p>
            {{ $laporan->follow_up_plan ?? '-' }}
        </p>
    </section>
</div>
