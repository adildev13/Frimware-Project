<?php

namespace App\Controller;

use App\Entity\SoftwareVersion;
use App\Repository\SoftwareVersionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SoftwareDownloadApiController extends AbstractController
{
    #[Route('/api2/carplay/software/version', name: 'api_software_download', methods: ['POST'])]
    public function resolve(Request $request, SoftwareVersionRepository $repository): JsonResponse
    {
        $version = (string) $request->request->get('version', '');
        $hwVersion = (string) $request->request->get('hwVersion', '');

        if ($version === '') {
            return new JsonResponse(['msg' => 'Version is required']);
        }

        if ($hwVersion === '') {
            return new JsonResponse(['msg' => 'HW Version is required']);
        }

        $patternST = '/^CPAA_[0-9]{4}\.[0-9]{2}\.[0-9]{2}(_[A-Z]+)?$/i';
        $patternGD = '/^CPAA_G_[0-9]{4}\.[0-9]{2}\.[0-9]{2}(_[A-Z]+)?$/i';
        $patternLCICic = '/^B_C_[0-9]{4}\.[0-9]{2}\.[0-9]{2}$/i';
        $patternLCINbt = '/^B_N_G_[0-9]{4}\.[0-9]{2}\.[0-9]{2}$/i';
        $patternLCIEvo = '/^B_E_G_[0-9]{4}\.[0-9]{2}\.[0-9]{2}$/i';

        $hwVersionValid = false;
        $st = false;
        $gd = false;
        $isLci = false;
        $lciHwType = '';

        if (preg_match($patternST, $hwVersion)) {
            $hwVersionValid = true;
            $st = true;
        }
        if (preg_match($patternGD, $hwVersion)) {
            $hwVersionValid = true;
            $gd = true;
        }
        if (preg_match($patternLCICic, $hwVersion)) {
            $hwVersionValid = true;
            $isLci = true;
            $lciHwType = 'CIC';
            $st = true;
        } elseif (preg_match($patternLCINbt, $hwVersion)) {
            $hwVersionValid = true;
            $isLci = true;
            $lciHwType = 'NBT';
            $gd = true;
        } elseif (preg_match($patternLCIEvo, $hwVersion)) {
            $hwVersionValid = true;
            $isLci = true;
            $lciHwType = 'EVO';
            $gd = true;
        }

        if (!$hwVersionValid) {
            return new JsonResponse(['msg' => 'There was a problem identifying your software. Contact us for help.']);
        }

        if (str_starts_with($version, 'v') || str_starts_with($version, 'V')) {
            $version = substr($version, 1);
        }

        $items = $repository->findBySystemVersionAltCaseInsensitive($version);
        foreach ($items as $item) {
            $isLciEntry = str_starts_with($item->getName(), 'LCI');
            if ($isLci !== $isLciEntry) {
                continue;
            }
            if ($isLci && stripos($item->getName(), $lciHwType) === false) {
                continue;
            }

            if ($item->isLatest()) {
                return new JsonResponse([
                    'versionExist' => true,
                    'msg' => 'Your system is upto date!',
                    'link' => '',
                    'st' => '',
                    'gd' => '',
                ]);
            }

            return new JsonResponse([
                'versionExist' => true,
                'msg' => 'The latest version of software is '.($isLci ? 'v3.4.4' : 'v3.3.7').' ',
                'link' => (string) $item->getLink(),
                'st' => $st ? (string) $item->getSt() : '',
                'gd' => $gd ? (string) $item->getGd() : '',
            ]);
        }

        return new JsonResponse([
            'versionExist' => false,
            'msg' => 'There was a problem identifying your software. Contact us for help.',
            'link' => '',
            'st' => '',
            'gd' => '',
        ]);
    }
}
