	if ($AmountPaidToFirm <= 0) {
				echo "fee : No data present for company: " . $companyName . "\n";
				array_push($noDataPresents, array(
					'paths' => $companyPath,
					'filename' => $fileName,
					'clientcode' => $companyName
				));
			} else {
				$outputPath = $reportBasePath . $companyPath . '/' . $fileName;
				if (!is_dir($reportBasePath . $companyPath)) {
					mkdir($reportBasePath . $companyPath, 0777, true);
				}
				$writer->writeToFile($outputPath);
				if (file_exists($outputPath)) {
					$FileSizeKB = getfileSize($outputPath);
					// VK26JAN2026 mailNotifaction($mailNotification, $companyPath, $companyName, $userType, $userReportName, $reportDescription);
					array_push($dataPresents, array(
						'paths' => $companyPath,
						'filename' => $fileName,
						'clientcode' => $companyName
					));
					// VK26JAN2026 ifDataPresent($companyStatus, $companyName, $reportName, $report_start_time, $sftpStatus, $FileSizeKB, $companyPath, $run_by,$userType);
					echo "Fee report generated successfully for company: " . $companyName . "\n"; // VK26JAN2026
				}
			}
		} else {
			// VK26JAN2026 ifDataNotPresent($companyStatus, $companyName, $reportName, $report_start_time, $sftpStatus, $FileSizeKB, $companyPath, $run_by,$userType);
			echo "fee : No data present for company: " . $companyName . "\n"; // VK26JAN2026
			array_push($noDataPresents, array(
				'paths' => $companyPath,
				'filename' => $fileName,
				'clientcode' => $companyName
			));
		}
		if (!empty($dataPresents)) {
			$new_status = 2;
			$status_msg = 'generated';
			$status = 1;
		} else {
			$new_status = 3;
			$status_msg = 'Failed';
			$status = 0;
		}
	}

	return array('status' => $status, 'status_msg' => $status_msg, 'new_status' => $new_status);
}