<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;


class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     */
    public function index(): Response
    {
        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
        ]);
    }

    /**
     * @Route("/doUpload", name="do-upload")
     * @param Request $request
     * @param string $uploadDir
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     * @return Response
     */
    public function upload(Request $request, string $uploadDir,
                          FileUploader $uploader, LoggerInterface $logger): Response
    {
        $token = $request->get("token");

        if (!$this->isCsrfTokenValid('upload', $token))
        {
            $logger->info("CSRF failure");

            return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/plain']);
        }

        $file1 = $request->files->get('file1');
        $file2 = $request->files->get('file2');

        if (empty($file1))
        {
            return new Response("No file specified",
                Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        if (empty($file2))
        {
            return new Response("No file2 specified",
                Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $filename = 'file1.csv';
        $uploader->upload($uploadDir, $file1, $filename);

        $filename = 'file2.csv';
        $uploader->upload($uploadDir, $file2, $filename);

       /* return new Response("File uploaded",  Response::HTTP_OK,
            ['content-type' => 'text/plain']);
       */
        return $this->redirectToRoute('readcsv');
    }
}
