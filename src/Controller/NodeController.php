<?php

namespace App\Controller;

use App\Entity\Node;
use App\Form\NodeType;
use App\Repository\NodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/node')]
class NodeController extends AbstractController
{
    #[Route('/', name: 'app_node_index', methods: ['GET'])]
    public function index(NodeRepository $nodeRepository): Response
    {
        return $this->render('node/index.html.twig', [
            'nodes' => $nodeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_node_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NodeRepository $nodeRepository): Response
    {
        $node = new Node();
        $form = $this->createForm(NodeType::class, $node);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nodeRepository->add($node, true);

            return $this->redirectToRoute('app_node_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('node/new.html.twig', [
            'node' => $node,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_node_show', methods: ['GET'])]
    public function show(Node $node): Response
    {
        return $this->render('node/show.html.twig', [
            'node' => $node,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_node_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Node $node, NodeRepository $nodeRepository): Response
    {
        $form = $this->createForm(NodeType::class, $node);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nodeRepository->add($node, true);

            return $this->redirectToRoute('app_node_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('node/edit.html.twig', [
            'node' => $node,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_node_delete', methods: ['POST'])]
    public function delete(Request $request, Node $node, NodeRepository $nodeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$node->getId(), $request->request->get('_token'))) {
            $nodeRepository->remove($node, true);
        }

        return $this->redirectToRoute('app_node_index', [], Response::HTTP_SEE_OTHER);
    }
}
