<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\Enums\BlogPostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words($this->faker->numberBetween(1, 5), true),
            'date' => $this->date ?? $this->faker->date(),
            'body' => $body ?? $this->markdown(),
            'author' => 'Brent',
            'status' => $this->faker->randomElement([
                BlogPostStatus::DRAFT()->value,
                BlogPostStatus::PUBLISHED()->value,
            ]),
            'likes' => $this->faker->numberBetween(10, 1000),
        ];
    }

    public function published(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => BlogPostStatus::PUBLISHED(),
            ];
        });
    }

    public function draft(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => BlogPostStatus::DRAFT(),
            ];
        });
    }

    private function markdown(): string
    {
        return <<<MD
        ## Tamen attonuit

        *Lorem* markdownum, Broteasque servat editus cum perenni, ut quae. Virtute equa
        non Icare ferre aetherias feremur tamen, armatosque alter, conveniunt si
        gentisque mersae!

            import = smmStatusBase(hoc_p.pimKeyboard(software.motion(5), 3,
                    frameworkWiki - ipad), rw.bit_basic_ajax(smartphoneMirroredClock,
                    registry + delete, solidDisk(-1)), pitch_link);
            flash.pdfFirewall(2);
            pim_dns_virus *= tapeCardOperating.power_only_copy.pcmciaCommercial(bcc,
                    rtfBoot, dual_smb_sram + compiler_soft_compatible);
            var ibm = wais.facebook(ics_card.youtube(dualTextBandwidth, -2) - 4);
            clip = cycle(miniLun(vlog), card_moodle_type, ipv_joystick);

        ## Ait tuli non et inmergere ergo Aurora

        Sis non **et patrem** et, ecce [tibi](http://laedere.org/), haesit tangit est
        **perenni ipsa** ordo. Ungues neu Picus quanto laudat iuvenis. Restant per teque
        videre, ut loco Latiis nec [est](http://reverentia-laesum.com/inpetus). Quoque
        claro illa, Eryx fecit ab iacet recipit turpe genibusque induitur tuus tepere
        utque. Et trepidos tellus Iuppiter infelix pennas et lactea flores naturae;
        **suo umbra**?

        - Saturnia augentur demittit pater nuper nando cacumine
        - Tamen inque Chromin demisit accipis poscit
        - Potest ad e ignis tenuere
        - Passura lata virgo
        - Qui avidum illam superosque huic

        ## Dure temperie semine et concurreret suos in

        Invidiam orba solacia postque mea *in examina curvos* haesit trepidare credita
        sonarent respicit fecit, gaudens velamina. Lynca furti Niobe mea Hectora simul
        proxima Parthenopen aevum adstitit nostrae; cum vicem [gerens melius
        iterum](http://nati.io/) non viderit. Aequora tristia defectos mihi gente: par
        inmutat velox, canes indignatus spolia, per.

        Trahere quoque ait praemia? Ipsa Ceae, suum quod herbas ingenium dubitat?
        Dextera vivat: arma studio, **per templa** trepidare datum intravere? In puer
        sanctae leones animos callidus; atque erat, disiunxisse. Dabat patre anguigenae
        talia.
        MD;
    }
}
