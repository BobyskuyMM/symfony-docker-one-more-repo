<?php

namespace App\Validator;

use App\Service\CompanySymbolChecker;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SymbolExistingValidator extends ConstraintValidator
{
    private $symbolCheckerService;
    
    public function __construct(CompanySymbolChecker $companySymbolChecker)
    {
        $this->symbolCheckerService = $companySymbolChecker;
    }
    
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof SymbolExisting) {
            throw new UnexpectedTypeException($constraint, SymbolExisting::class);
        }
        
        if (!$this->symbolCheckerService->checkSymbol($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
